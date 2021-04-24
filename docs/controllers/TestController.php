<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @SWG\Post(
     *     path="/api/login",
     *     description="登录接口",
     *     operationId="/api/login",
     *     produces={"application/json"},
     *     tags={"登录接口"},
     *     @SWG\Parameter(
     *         in="formData",
     *         name="email",
     *         type="string",
     *         description="用户邮箱",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         in="formData",
     *         name="password",
     *         type="string",
     *         description="用户密码",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="成功",
     *         @SWG\Schema(
     *                 @SWG\Property(
     *                 property="Token",
     *                 type="string",
     *                 description="返回Token",
     *                 example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsNTQudGVzdC5jb21cL2FwaVwvbG9naW4iLCJpYXQiOjE1Mzc0OTQ5MTUsImV4cCI6MTUzNzQ5ODUxNSwibmJmIjoxNTM3NDk0OTE1LCJqdGkiOiJmR0gzZmlDRk5KR1dadUx0Iiwic3ViIjo2NywicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.37v2bmhKipJ2Hit-2p2sil6gZ3G1fRG5PmvNOyLNzec"
     *             )
     *          )
     *     )
     * )
     */
    public function login()
    {
    }
    /**
     * @SWG\Post(
     *     path="/api/register",
     *     description="注册接口",
     *     operationId="/api/register",
     *     produces={"application/json"},
     *     tags={"注册接口"},
     *     @SWG\Parameter(
     *         in="formData",
     *         name="email",
     *         type="string",
     *         description="用户邮箱",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         in="formData",
     *         name="password",
     *         type="string",
     *         description="用户密码",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         in="formData",
     *         name="name",
     *         type="string",
     *         description="用户名",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="成功",
     *         @SWG\Schema(
     *                 @SWG\Property(
     *                 property="Token",
     *                 type="string",
     *                 description="返回Token",
     *                 example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsNTQudGVzdC5jb21cL2FwaVwvbG9naW4iLCJpYXQiOjE1Mzc0OTQ5MTUsImV4cCI6MTUzNzQ5ODUxNSwibmJmIjoxNTM3NDk0OTE1LCJqdGkiOiJmR0gzZmlDRk5KR1dadUx0Iiwic3ViIjo2NywicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.37v2bmhKipJ2Hit-2p2sil6gZ3G1fRG5PmvNOyLNzec"
     *             )
     *          )
     *     )
     * )
     */
    public function register()
    {
    }
}