<?php

namespace Lmh\ESign\Foundation\Template;

use Lmh\ESign\Kernel\BaseClient;
use Lmh\ESign\Exceptions\HttpException;
use Lmh\ESign\Support\Collection;

class Client extends BaseClient
{

    /**
     * 查询模板文件详情
     *
     * @param string $templateId
     * @return Collection|null
     * @throws HttpException
     */
    public function queryTemplate(string $templateId):?array
    {
        $url = '/v1/docTemplates/' . $templateId;
        return $this->request('get', [$url]);
    }


    /**
     * 查询e签宝官网模板信息
     * @param $pageNum
     * @param $pageSize
     * @return Collection|null
     * @throws HttpException
     * @author lmh
     */
    public function getFlowTemplateList($pageNum, $pageSize):?array
    {
        $url = "/v3/flow-templates/basic-info";
        $params = [
            'pageNum' => $pageNum,
            'pageSize' => $pageSize,
        ];
        return $this->request('get', [$url, $params]);
    }
}