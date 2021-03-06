<?php

namespace Lmh\ESign\Foundation\File;

use Lmh\ESign\Kernel\BaseClient;
use Lmh\ESign\Exceptions\HttpException;
use Lmh\ESign\Support\Collection;

class Client extends BaseClient
{
    /**
     * 查询PDF文件详情
     *
     * @param string $fileId
     * @return Collection|null
     */
    public function queryFileInfo(string $fileId): ?array
    {
        $url = '/v1/files/' . $fileId;
        return $this->request('get', [$url]);
    }

    /**
     * 填充内容生成PDF
     * 注意：E签宝官网获取的模板id，在通过模板创建文件的时候只支持输入项组件id+填充内容
     * @param $templateId
     * @param $name
     * @param $simpleFormFields
     * @return Collection|null
     */
    public function createByTemplateId(string $templateId, $name, $simpleFormFields): ?array
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