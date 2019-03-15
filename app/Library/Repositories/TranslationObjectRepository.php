<?php

namespace Aleksa\Library\Repositories;

use Illuminate\Support\Collection;
use Aleksa\Library\Services\LocaleService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Aleksa\Library\Exceptions\ItemNotFoundException;
use Aleksa\Library\Services\Translator;

class TranslationObjectRepository extends ObjectRepository
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

        $query = $this->join()
            ->where('locale_id', '=', LocaleService::get()->id);

        $query = $this->queryProcessor->process($query, $params);
        $query = $query->select($this->tableName . '.*');

        return $query->get();
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
        $translationData['locale_id'] = $translationData['locale_id'] ?: LocaleService::get()->id;
        $translationData[$this->translationForeignKey] = $item[$this->parentPrimaryKey];

        if (($existing = $this->getTranslation($item->id, $translationData['locale_id'], false)->first())) {
            $translationData['id'] = $existing->id;
        }

        $this->translationRepository->save($translationData);
    }

    public function getTranslation($itemId, $localeId = null, $throw = true): Builder
    {
        $localeId = $localeId ?: LocaleService::get()->id;

        $translation = $this->getTranslations($itemId)
            ->where('locale_id', '=', $localeId);

        if (!$translation->first() && $throw) {
            throw new ItemNotFoundException(Translator::get('exceptions.translation.not_found'));
        }

        return $translation;
    }

    public function getTranslationById($itemId, $translationId): Model
    {
        $translation = $this->getTranslations($itemId)
            ->where($this->translationTableName . '.id', '=', $translationId)->first();

        if (!$translation) {
            throw new ItemNotFoundException(Translator::get('exceptions.translation.not_found'));
        }

        return $translation;
    }

    public function getTranslations($itemId): Builder
    {
        $query = $this->join()->where($this->tableName . '.' . $this->parentPrimaryKey, '=', $itemId);

        return $query->select($this->translationTableName . '.*');
    }

    public function removeTranslation($itemId)
    {
        $translation = $this->getTranslation($itemId)->first();

        return $this->removeTranslationModel($itemId, $translation);
    }

    public function removeTranslationById($id, $translationId)
    {
        $translation = $this->getTranslationById($id, $translationId);

        return $this->removeTranslationModel($id, $translation);
    }

    private function removeTranslationModel($itemId, $translation)
    {
        $translation = $this->translationRepository->delete($translation->id);

        if (!$this->getTranslations($itemId)->get()->count()) {
            $this->model->where($this->parentPrimaryKey, '=', $itemId)->delete();
            $this->throwEvent($this->deleteEvent);
        }

        return $translation;
    }

    private function join(): Builder
    {
        return $this->model->newQuery()->join(
            $this->translationTableName,
            $this->tableName . '.' . $this->parentPrimaryKey,
            '=',
            $this->translationTableName . '.' . $this->translationForeignKey
        );
    }
}
