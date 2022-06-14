<?php

namespace Lmh\ESign\Foundation\File;

use Lmh\ESign\Core\BaseClient;
use Lmh\ESign\Exceptions\HttpException;
use Lmh\ESign\Support\Collection;

class Client extends BaseClient
{
    /**
     * 查询PDF文件详情
     *
     * @param string $fileId
     * @return Collection|null
     * @throws HttpException
     */
    public function queryFileInfo(string $fileId): ?Collection
    {
        $url = '/v1/files/' . $fileId;
        return $this->request('get', [$url]);
    }

    /**
     * 填充内容生成PDF
     * @param $templateId
     * @param $name
     * @param $simpleFormFields
     * @return Collection|null
     * @throws HttpException
     */
    public function createByTemplateId(string $templateId, $name, $simpleFormFields): ?Collection
    {
        $url = '/v1/files/createByTemplate';
        $params = [
            'name' => $name,
            'templateId' => $templateId,
            'simpleFormFields' => $simpleFormFields,
        ];
        return $this->request('json', [$url, $params]);
    }

}