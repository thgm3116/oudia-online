<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class DiaFileUploadForm extends Form
{
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('diafile', 'diafile', [
            'rule' => ['uploadedFile', [
                //'types' => Configure::read('image.allow_mime_types'),
                //'maxSize' => Configure::read('image.max_size')
            ]],
            'provider' => 'custom',
            'message' => 'サイズが大きすぎるか、不正なファイルタイプです'
        ]);
    }

    protected function _execute(array $data)
    {
        return true;
    }
}
