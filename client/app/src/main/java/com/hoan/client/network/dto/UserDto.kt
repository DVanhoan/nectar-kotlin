package com.hoan.client.network.dto

import com.hoan.client.model.User
import com.squareup.moshi.Json

data class LoginRequest(
    val email: String,
    val password: String
)


data class RegisterRequest(
    val name: String,
    val email: String,
    val password: String
)

data class LoginResponse(
    @Json(name="access_token")
    val accessToken: String,

    @Json(name="token_type")
    val tokenType:  String,

    @Json(name="expires_in")
    val expiresIn:  Long,

    @Json(name="user")
    val user: User
)

data class FacebookLoginRequest(
    @Json(name = "access_token") val accessToken: String
)