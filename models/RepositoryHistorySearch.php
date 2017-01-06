<?php

namespace app\models;

use app\models\RepositoryHistory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RepositoryHistorySearch represents the model behind the search form about `app\models\RepositoryHistory`.
 */
class RepositoryHistorySearch extends RepositoryHistory
{
    public $repoName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'repo_id', 'created_at', 'updated_at'], 'integer'],
            [['repo', 'commit', 'author', 'modified', 'added', 'removed'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RepositoryHistory::find();

        $query->joinWith(['repo']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['repo_id'] = [
            'asc'  => ['repository.name' => SORT_ASC],
            'desc' => ['repository.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'repo_id'    => $this->repo_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'commit', $this->commit])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'modified', $this->modified])
            ->andFilterWhere(['like', 'added', $this->added])
            ->andFilterWhere(['like', 'removed', $this->removed]);

        return $dataProvider;
    }
}
