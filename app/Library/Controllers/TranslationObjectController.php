<?php

namespace Aleksa\Library\Controllers;

use Aleksa\Library\Services\LocaleService;

class TranslationObjectController extends ObjectController
{
    public function destroyTranslationById($id, $translationId)
    {
        $this->repository->removeTranslationById($id, $translationId);

        return $this->respond([], 200, 'Successfully deleted translation.');
    }

    public function destroyTranslation($id)
    {
        $this->repository->removeTranslation($id);

        return $this->respond([], 200, 'Successfully removed translation for locale \'' . LocaleService::get()->code . '\'');
    }
}
