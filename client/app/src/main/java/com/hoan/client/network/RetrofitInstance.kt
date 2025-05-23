package com.hoan.client.network

import com.hoan.client.network.services.AuthService
import com.squareup.moshi.Moshi
import com.squareup.moshi.kotlin.reflect.KotlinJsonAdapterFactory
import okhttp3.Interceptor
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.moshi.MoshiConverterFactory

import okhttp3.logging.HttpLoggingInterceptor

object RetrofitInstance {
    private var token: String = ""

    fun setToken(newToken: String) {
        token = newToken
    }

    private val logging = HttpLoggingInterceptor().apply {
        level = HttpLoggingInterceptor.Level.BODY
    }

    private val client = OkHttpClient.Builder()
        .addInterceptor(logging)
        .addInterceptor(Interceptor { chain ->
            val req = chain.request().newBuilder()
                .addHeader("Authorization", "Bearer $token")
                .build()
            chain.proceed(req)
        })
        .build()

    private val moshi = Moshi.Builder()
        .addLast(KotlinJsonAdapterFactory())
        .build()

    private val retrofit = Retrofit.Builder()
        .client(client)
        .baseUrl("http://192.168.1.9:8000/api/v1/")
        .addConverterFactory(MoshiConverterFactory.create(moshi))
        .build()

    val authService: AuthService = retrofit.create(AuthService::class.java)
}
