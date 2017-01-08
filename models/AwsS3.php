<?php

namespace app\models;

use Aws\S3\S3Client;
use Aws\Sdk;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class AwsS3 extends Model
{
    const ACL_PRIVATE                   = 'private';
    const ACL_PUBLIC_READ               = 'public-read';
    const ACL_PUBLIC_READ_WRITE         = 'public-read-write';
    const ACL_AUTHENTICATED_READ        = 'authenticated-read';
    const ACL_BUCKET_OWNER_READ         = 'bucket-owner-read';
    const ACL_BUCKET_OWNER_FULL_CONTROL = 'bucket-owner-full-control';
    const ACL_LOG_DELIVERY_WRITE        = 'log-delivery-write';

    public $source;
    public $bucket;
    public $key;
    public $acl;

    public function rules()
    {
        return [
            [['source', 'bucket', 'key'], 'required', 'on' => 'put'],
            [['bucket', 'key'], 'required', 'on' => 'get'],
            [['bucket', 'key'], 'required', 'on' => 'presignedUrl'],
            [['bucket', 'key'], 'required', 'on' => 'delete'],
            [['bucket', 'key'], 'required', 'on' => 'download'],
        ];
    }

    public function uploadObject($source, $bucket, $key, $acl = self::ACL_PUBLIC_READ)
    {
        $configAws = $this->findConfig();

        $this->source   = $source;
        $this->bucket   = $bucket;
        $this->key      = $key;
        $this->acl      = $acl;
        $this->scenario = 'put';
        if ($this->validate()) {
            $sdk = new Sdk([
                'version'     => 'latest',
                'region'      => $configAws->region,
                'credentials' => [
                    'key'    => $configAws->key,
                    'secret' => $configAws->secret,
                ],
            ]);
            $s3   = $sdk->createS3();
            $file = null;
            try {
                $file   = fopen($this->source, 'r');
                $result = $s3->upload($this->bucket, $this->key, $file, $this->acl, ['Content-Type' => $this->getContentType()]);
                return $result->get('ObjectURL');
            } catch (\Exception $e) {
                Yii::error('Error uploading files to S3. ' . $e->getMessage());
            }
            if ($file != null) {
                fclose($file);
            }
            return false;
        } else {
            return false;
        }
    }

    public function deleteObject($bucket, $key)
    {
        $configAws = $this->findConfig();

        $this->bucket   = $bucket;
        $this->key      = $key;
        $this->scenario = 'delete';
        if ($this->validate()) {
            try {
                $client = new S3Client([
                    'version'     => 'latest',
                    'region'      => $configAws->region,
                    'credentials' => [
                        'key'    => $configAws->key,
                        'secret' => $configAws->secret,
                    ],
                ]);
                $client->registerStreamWrapper();
                return unlink('s3://' . $bucket . '/' . $key);
            } catch (\Exception $e) {
                Yii::error('Error deleting object from S3. Bucket - ' . $this->bucket . ' Key - ' . $this->key . ' Extra - ' . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    public function getPreSignedUrl($bucket, $key, $expiryInMinutes = 10)
    {
        $configAws = $this->findConfig();

        $this->bucket   = $bucket;
        $this->key      = $key;
        $this->scenario = 'delete';
        if ($this->validate()) {
            try {
                $s3Client = new S3Client([
                    'version'     => 'latest',
                    'region'      => $configAws->region,
                    'credentials' => [
                        'key'    => $configAws->key,
                        'secret' => $configAws->secret,
                    ],
                ]);
                $cmd = $s3Client->getCommand('GetObject', [
                    'Bucket' => $this->bucket,
                    'Key'    => $this->key,
                ]);
                $request = $s3Client->createPresignedRequest($cmd, '+' . $expiryInMinutes . ' minutes');
                return (string) $request->getUri();
            } catch (\Exception $e) {
                Yii::error('Error getting pre-signed url from S3. Bucket - ' . $this->bucket . ' Key - ' . $this->key . ' Extra - ' . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    public function downloadObject($bucket, $key)
    {
        $configAws = $this->findConfig();

        $this->bucket   = $bucket;
        $this->key      = $key;
        $this->scenario = 'download';
        if ($this->validate()) {
            try {
                $client = new S3Client([
                    'version'     => 'latest',
                    'region'      => $configAws->region,
                    'credentials' => [
                        'key'    => $configAws->key,
                        'secret' => $configAws->secret,
                    ],
                ]);
                $client->registerStreamWrapper();
                return file_get_contents('s3://' . $bucket . '/' . $key);
            } catch (\Exception $e) {
                Yii::error('Error getting file content from S3. Bucket - ' . $this->bucket . ' Key - ' . $this->key . ' Extra - ' . $e->getMessage());
                return null;
            }
        }
        return null;
    }

    public function getContentType()
    {
        $finfo       = finfo_open(FILEINFO_MIME_TYPE);
        $contentType = finfo_file($finfo, $this->source);
        finfo_close($finfo);
        return $contentType;
    }

    protected function findConfig($id = 1)
    {
        if (($model = ConfigAws::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
