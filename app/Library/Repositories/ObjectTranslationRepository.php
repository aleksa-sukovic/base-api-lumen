<?php

namespace Aleksa\Library\Repositories;

use Illuminate\Support\Collection;
use Aleksa\Library\Services\LocaleService;
use Illuminate\Database\Eloquent\Model;

class ObjectTranslationRepository extends ObjectRepository
{
    protected $tableName;
    protected $translationTableName;
    protected $translationForeignKey;
    protected $parentPrimaryKey;
    protected $translationRepository;

    public function all(array $params): Collection
    {
        $params = $this->processParams($params);
        $query = $this->model->newQuery();

        $query = $query->join(
            $this->translationTableName,
            $this->tableName . '.' . $this->parentPrimaryKey,
            '=',
            $this->translationTableName . '.' . $this->translationForeignKey
        )->where('locale_id', '=', LocaleService::get()->id)
        ->select($this->tableName . '.*');

        $query = $this->queryProcessor->process($query, $params);

        $items = $query->get();

        return $items;
    }

    public function afterSave(Model $item, array $params)
    {
        if (isset($params['translations'])) {
            $this->saveTranslations($item, $params['translations']);
        }

        if (isset($params['translation'])) {
            $this->saveTranslation($item, $params['translation']);
        }
    }

    protected function saveTranslations(Model $item, array $translationsData = [])
    {
        foreach ($translationsData as $translationData) {
            $this->saveTranslation($item, $translationData);
        }
    }

    protected function saveTranslation(Model $item, $translationData = [])
    {
        if (!isset($translationData['locale_id'])) {
            $translationData['locale_id'] = LocaleService::get()->id;
        }
        $translationData[$this->translationForeignKey] = $item[$this->parentPrimaryKey];

        if (($existing = $this->getTranslation($translationData['locale_id'])->first())) {
            $translationData['id'] = $existing->id;
        }

        $this->translationRepository->save($translationData);
    }

    protected function getTranslation($locale = 'en')
    {
        return $this->model->newQuery()->join(
            $this->translationTableName,
            $this->tableName . '.' . $this->parentPrimaryKey,
            '=',
            $this->translationTableName . '.' . $this->translationForeignKey
        )->where('locale_id', '=', $locale);
    }
}
