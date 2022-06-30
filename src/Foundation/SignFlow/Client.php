<?php

namespace Lmh\ESign\Foundation\SignFlow;

use Lmh\ESign\Exceptions\HttpException;
use Lmh\ESign\Kernel\BaseClient;
use Lmh\ESign\Support\Collection;

class Client extends BaseClient
{
    /**
     * 一步发起签署
     *
     * @param array $params
     * @return Collection|null
     */
    public function createFlowOneStep(array $params): ?array
    {
        $url = '/api/v2/signflows/createFlowOneStep';
        return $this->request('json', [$url, $params]);
    }

    /**
     * 签署流程创建
     *
     * @param string $businessScene
     * @param string|null $noticeDeveloperUrl
     * @param string $noticeType 通知方式，逗号分割，1-短信，2-邮件 。默认值1，
     * @param string $redirectUrl
     * @param bool $autoArchive
     * @return Collection|null
     */
    public function createSignFlow(string $businessScene, string $noticeDeveloperUrl = null, string $noticeType = '1', $redirectUrl = '', $autoArchive = true): ?array
    {
        $url = '/v1/signflows';
        $params = [
            'autoArchive' => $autoArchive,
            'businessScene' => $businessScene,
            'configInfo' => [
                'noticeType' => $noticeType,
                'noticeDeveloperUrl' => $noticeDeveloperUrl,
                'redirectUrl' => $redirectUrl,
            ]
        ];
        return $this->request('json', [$url, $params]);
    }

    /**
     * 流程文档添加
     *
     * @param $flowId
     * @param $fileId
     * @param int $encryption
     * @param null $fileName
     * @param null $filePassword
     * @return Collection|null
     */
    public function addDocuments($flowId, $fileId, $encryption = 0, $fileName = null, $filePassword = null): ?array
    {
        $url = '/v1/signflows/' . $flowId . '/documents';
        $params = [
            'docs' => [
                ['fileId' => $fileId, 'encryption' => $encryption, 'fileName' => $fileName, 'filePassword' => $filePassword],
            ]
        ];
        return $this->request('json', [$url, $params]);
    }

    /**
     * 添加平台自动盖章签署区
     *
     * @param string $flowId
     * @param string $fileId
     * @param string $sealId
     * @param array $posBean [
     *   'posPage' => $posPage,
     *   'posX' => $posX,
     *   'posY' => $posY,
     * ]
     * @param int $signDateBeanType
     * @param array|null $signDateBean
     * @param int $signType 签署类型， 1-单页签署，2-骑缝签署，默认1
     * @return Collection|null
     * @see https://open.esign.cn/doc/detail?id=opendoc%2Fsaas_api%2Folgmg0_xi1khu&namespace=opendoc%2Fsaas_api
     */
    public function addPlatformSign(string $flowId, string $fileId, string $sealId, array $posBean, $signDateBeanType = 0, ?array $signDateBean = null, int $signType = 1): ?array
    {
        $url = '/v1/signflows/' . $flowId . '/signfields/platformSign';
        $signFieldOne = [
            'fileId' => $fileId,
            'sealId' => $sealId,
            'posBean' => $posBean,
            'signDateBeanType' => $signDateBeanType,
            'signDateBean' => $signDateBean,
            'signType' => $signType,
        ];
        $params = [
            'signfields' => [
                $signFieldOne,
            ]
        ];
        return $this->request('json', [$url, $params]);
    }

    /**
     * 添加签署方自动盖章签署区
     *
     * @param $flowId
     * @param $fileId
     * @param $authorizedAccountId
     * @param $sealId
     * @param $posPage
     * @param $posX
     * @param $posY
     * @param int $signDateBeanType
     * @param null $signDateBean
     * @param null $signType
     * @return Collection|null
     */
    public function addAutoSign($flowId, $fileId, $authorizedAccountId, $sealId, $posPage, $posX, $posY, $signDateBeanType = 0, $signDateBean = null, $signType = null): ?array
    {
        $url = '/v1/signflows/' . $flowId . '/signfields/autoSign';
        $signFieldOne = [
            'fileId' => $fileId,
            'authorizedAccountId' => $authorizedAccountId,
            'sealId' => $sealId,
            'posBean' => [
                'posPage' => $posPage,
                'posX' => $posX,
                'posY' => $posY,
            ],
            'signDateBeanType' => $signDateBeanType,
            'signDateBean' => $signDateBean,
            'signType' => $signType,
        ];

        $params = [
            'signfields' => [
                $signFieldOne,
            ]
        ];
        return $this->request('json', [$url, $params]);
    }

    /**
     * 添加手动盖章签署区
     *
     * @param string $flowId
     * @param string $fileId
     * @param string $signerAccountId
     * @param array $posBean ['posPage' => $posPage,'posX' => $posX,'posY' => $posY,]
     * @param string|null $authorizedAccountId 签约主体账号标识，即本次签署对应任务的归属方，如传入机构id，则签署完成后，本任务可在企业账号下进行管理，默认是签署操作人个人
     * @param int $signDateBeanType 是否需要添加签署日期，默认0 0-禁止 1-必须 2-不限制
     * @param array|null $signDateBean 签章日期信息，骑缝章默认不展示日期
     * @return Collection|null
     * @see https://open.esign.cn/doc/detail?id=opendoc%2Fsaas_api%2Fgcg9zw_gu3zvg&namespace=opendoc%2Fsaas_api
     */
    public function addHandSign(string $flowId, string $fileId, string $signerAccountId, array $posBean, ?string $authorizedAccountId = null, int $signDateBeanType = 2, ?array $signDateBean = null): ?array
    {
        $url = '/v1/signflows/' . $flowId . '/signfields/handSign';
        $signFieldOne = [
            'fileId' => $fileId,
            'signerAccountId' => $signerAccountId,
            'posBean' => $posBean,
            'signDateBeanType' => $signDateBeanType,
            'signDateBean' => $signDateBean,
        ];
        if ($authorizedAccountId) {
            $signFieldOne['authorizedAccountId'] = $authorizedAccountId;
        }
        $params = [
            'signfields' => [
                $signFieldOne,
            ]
        ];
        return $this->request('json', [$url, $params]);
    }

    /**
     * 流程开始
     *
     * @param $flowId
     * @return Collection|null
     */
    public function startSignFlow(string $flowId): ?array
    {
        $url = '/v1/signflows/' . $flowId . '/start';
        return $this->request('put', [$url]);
    }

    /**
     * 获取签署地址
     * @param $flowId
     * @param $accountId
     * @param null $orgId
     * @param int $urlType
     * @param null $appScheme
     * @return Collection|null
     */
    public function getExecuteUrl(string $flowId, $accountId, $orgId = null, $urlType = 0, $appScheme = null): ?array
    {
        $url = '/v1/signflows/' . $flowId . '/executeUrl';
        $params = [
            'accountId' => $accountId,
            'organizeId' => $orgId,
            'urlType' => $urlType,
            'appScheme' => $appScheme
        ];
        return $this->request('get', [$url, $params]);
    }
}