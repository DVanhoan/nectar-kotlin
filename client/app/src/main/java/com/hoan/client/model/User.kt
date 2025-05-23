package com.hoan.client.model

import com.squareup.moshi.Json

data class User(
    val id: Long,

    val name: String,

    val email: String,

    @Json(name="phone_number")
    val phoneNumber: String,

    @Json(name="avatar_url")
    val avatarUrl: String?,

    val role: String,

    @Json(name="created_at")
    val createdAt: String,

    @Json(name="updated_at")
    val updatedAt: String
)