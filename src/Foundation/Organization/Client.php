<?php

namespace Lmh\ESign\Foundation\Organization;

use Lmh\ESign\Exceptions\HttpException;
use Lmh\ESign\Kernel\BaseClient;
use Lmh\ESign\Support\Collection;

class Client extends BaseClient
{

    /**
     * 创建机构签署账号
     *
     * @param $thirdPartyUserId string 第三方平台标识, 如: 统一信用代码
     * @param $name string 机构名称
     * @param $idNumber string 证件号
     * @param string|null $orgLegalIdNumber string 企业法人证件号
     * @param string|null $orgLegalName string 企业法人名称
     * @param $idType string 证件类型, 默认: CRED_ORG_USCC 统一社会信用代码
     * @return Collection|null
     */
    public function createOrganizeAccount(string $thirdPartyUserId, string $name, string $idNumber,?string $orgLegalIdNumber = null, ?string $orgLegalName = null, string $idType = 'CRED_ORG_USCC'): ?array
    {
        $url = '/v1/organizations/createByThirdPartyUserId';
        $params = [
            'thirdPartyUserId' => $thirdPartyUserId,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
        ];
        if ($orgLegalIdNumber) {
            $params['orgLegalIdNumber'] = $orgLegalIdNumber;
        }
        if ($orgLegalName) {
            $params['orgLegalName'] = $orgLegalName;
        }

        return $this->request('json', [$url, $params]);
    }

    /**
     * 查询机构信息 by 账户id
     *
     * @param $orgId
     * @return Collection|null
     */
    public function queryOrganizeByOrgId(string $orgId): ?array
    {
        $url = '/v1/organizations/' . $orgId;

        return $this->request('get', [$url]);
    }

    /**
     * 查询机构信息 by 第三方id
     *
     * @param $thirdId
     * @return Collection|null
     */
    public function queryOrganizeByThirdId($thirdId): ?array
    {
        $url = '/v1/organizations/getByThirdId';
        $params = [
            'thirdPartyUserId' => $thirdId
        ];

        return $this->request('get', [$url, $params]);
    }

    /**
     * 更新机构信息
     *
     * @param $orgId
     * @param string|null $name
     * @param string|null $idType
     * @param string|null $idNumber
     * @param string|null $orgLegalIdNumber
     * @param string|null $orgLegalName
     * @return Collection|null
     */
    public function updateOrganizeByAccountId(string $orgId, $name = null, $idType = null, $idNumber = null, $orgLegalIdNumber = null, $orgLegalName = null): ?array
    {
        $url = '/v1/organizations/' . $orgId;
        $params = [
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
            'orgLegalIdNumber' => $orgLegalIdNumber,
            'orgLegalName' => $orgLegalName,
        ];

        return $this->request('put', [$url, $params]);
    }

    /**
     * 查询授权印章列表
     * @param $orgId
     * @param bool $downloadFlag
     * @param int $offset
     * @param int $size
     * @return Collection|null  是否返回印章图片下载地址，默认为truetrue-返回下载链接 false-不返回下载链接
     * @author lmh
     */
    public function queryGrantedSeals(string $orgId, $downloadFlag = true, $offset = 0, $size = 10): ?array
    {
        $url = '/v1/organizations/' . $orgId . '/granted/seals';
        $params = [
            'downloadFlag' => $downloadFlag,
            'offset' => $offset,
            'size' => $size,
        ];
        return $this->request('get', [$url, $params]);
    }
}