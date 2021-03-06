<?php

namespace Lmh\ESign\Foundation\Account;

use Lmh\ESign\Kernel\BaseClient;
use Lmh\ESign\Support\Collection;

class Client extends BaseClient
{
    /**
     * 创建个人账号
     *
     * @param string $thirdPartyUserId 创建个人账号的唯一标识。可将个人证件号、手机号、邮箱地址等作为此账号的唯一标识。
     * @param string $name
     * @param string|null $idNumber
     * @param string|null $mobile
     * @param string|null $email
     * @param $idType string 证件类型, 默认: CRED_PSN_CH_IDCARD
     * @return Collection|null
     */
    public function createPersonAccount(string $thirdPartyUserId, string $name, ?string $idNumber = null, ?string $mobile = null, ?string $email = null, string $idType = 'CRED_PSN_CH_IDCARD'): ?array
    {
        $url = '/v1/accounts/createByThirdPartyUserId';
        $params = [
            'thirdPartyUserId' => $thirdPartyUserId,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
            'mobile' => $mobile,
        ];
        if ($email) {
            $params['email'] = $email;
        }
        return $this->request('json', [$url, $params]);
    }

    /**
     * 查询个人信息By账户id
     *
     * @param $accountId
     * @return Collection|null
     *
     */
    public function queryPersonByAccountId($accountId): ?array
    {
        $url = '/v1/accounts/' . $accountId;
        return $this->request('get', [$url]);
    }

    /**
     * 查询个人信息By第三方id
     *
     * @param $thirdId
     * @return Collection|null
     */
    public function queryPersonByThirdId($thirdId): ?array
    {
        $url = '/v1/accounts/getByThirdId';
        $params = [
            'thirdPartyUserId' => $thirdId
        ];

        return $this->request('get', [$url, $params]);
    }

    /**
     * 更新个人信息
     *
     * @param $accountId
     * @param null $mobile
     * @param null $email
     * @param null $name
     * @param null $idType
     * @param null $idNumber
     * @return Collection|null
     */
    public function updatePersonByAccountId($accountId, $mobile = null, $email = null, $name = null, $idType = null, $idNumber = null): ?array
    {
        $url = '/v1/accounts/' . $accountId;
        $params = [
            'mobile' => $mobile,
            'email' => $email,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
        ];

        return $this->request('put', [$url, $params]);
    }

    /**
     * 静默签署授权
     *
     * @param $accountId
     * @param string|null $deadline 授权截止时间, 格式为yyyy-MM-dd HH:mm:ss，默认无限期
     * @return Collection|null
     */
    public function signAuth($accountId, $deadline = null): ?array
    {
        $url = '/v1/signAuth/' . $accountId;
        $params = [
            'deadline' => $deadline,
        ];

        return $this->request('json', [$url, $params]);
    }

    /**
     * 取消静默签署授权
     *
     * @param $accountId
     * @return Collection|null
     */
    public function cancelSignAuth($accountId): ?array
    {
        $url = "/v1/signAuth/{$accountId}";

        return $this->request('delete', [$url]);
    }
}