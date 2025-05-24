package com.hoan.client.network.services

import com.hoan.client.model.User
import com.hoan.client.network.dto.FacebookLoginRequest
import com.hoan.client.network.dto.LoginRequest
import com.hoan.client.network.dto.LoginResponse
import com.hoan.client.network.dto.RegisterRequest
import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST

interface AuthService {
    @POST("users/login")
    fun login(@Body req: LoginRequest): Call<LoginResponse>

    @POST("users/register")
    fun register(@Body req: RegisterRequest): Call<User>

    @GET("users/user/me")
    fun getUser(): Call<User>

    @POST("users/refresh")
    fun refreshToken(): Call<LoginResponse>

    @POST("users/auth/facebook")
    fun facebookLogin(@Body req: FacebookLoginRequest): Call<LoginResponse>
}