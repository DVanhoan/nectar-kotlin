package com.hoan.client

import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import android.os.Bundle
import android.util.Log
import android.view.inputmethod.InputMethodManager
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.hoan.client.databinding.ActivityLoginBinding
import com.hoan.client.network.RetrofitInstance
import com.hoan.client.network.dto.LoginRequest
import com.hoan.client.network.dto.LoginResponse
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class LoginActivity : AppCompatActivity() {
    private lateinit var binding: ActivityLoginBinding

    private lateinit var sharedPreferences: SharedPreferences

    private val sharedPrefName = "user_shared_preference"


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)

        sharedPreferences = getSharedPreferences(sharedPrefName, Context.MODE_PRIVATE)

        binding.btnLogin.setOnClickListener {
            (getSystemService(INPUT_METHOD_SERVICE) as InputMethodManager)
                .hideSoftInputFromWindow(binding.btnLogin.windowToken, 0)

            val email = binding.etEmail.text.toString()
            val password = binding.etPassword.text.toString()

            if (validateEmail(email) && validatePassword(password)) {
                val loginReq = LoginRequest(email, password)
                RetrofitInstance.authService.login(loginReq)
                    .enqueue(object: Callback<LoginResponse> {
                        override fun onResponse(call: Call<LoginResponse>, resp: Response<LoginResponse>) {
                            Log.d("LOGIN", "code = ${resp.code()}, errorBody = ${resp.errorBody()?.string()}")
                            if (resp.isSuccessful && resp.body() != null) {
                                resp.body()?.let { loginResp ->
                                    loginSuccess(loginResp)
                                    Log.d("LOGIN", "Login successful")
                                } ?: run {
                                    Log.e("LOGIN", "Empty body")
                                }
                            } else {
                                Log.e("LOGIN", "Error body = ${resp.errorBody()?.string()}")
                                Toast.makeText(this@LoginActivity, "Login failed (${resp.code()})", Toast.LENGTH_SHORT).show()
                            }
                        }

                        override fun onFailure(call: Call<LoginResponse>, t: Throwable) {
                            Toast.makeText(this@LoginActivity, "Login failed", Toast.LENGTH_SHORT).show()
                        }
                    })
            } else {
                if (!validateEmail(email)) {
                    binding.etEmail.error = "Invalid email format"
                }
                if (!validatePassword(password)) {
                    binding.etPassword.error = "Password must be at least 6 characters"
                }
            }
        }

        binding.linkSignup.setOnClickListener {
            startActivity(Intent(this, SignUpActivity::class.java))
            finish()
        }

    }



    private fun loginSuccess(responseBody: LoginResponse) {
        Log.d("LOGIN_SUCCESSFUL", "Token: ${responseBody.accessToken}")
        saveSharedPreferences(responseBody)
        startActivity(Intent(this, MainActivity::class.java))
        finish()
    }


    private fun saveSharedPreferences(response: LoginResponse) {
        val editor: SharedPreferences.Editor = sharedPreferences.edit()

        editor.putString("access_token", response.accessToken)
        editor.putString("token_type", response.tokenType)
        editor.putLong("user_id", response.user.id)

        val expirationTime = System.currentTimeMillis() + response.expiresIn * 1000L
        editor.putLong("expiration_time", expirationTime)

        editor.apply()
    }

    private fun loginError(statusCode: Int, e: Throwable) {
        val errorMessage = when (statusCode) {
            400 -> "Wrong credentials"
            500 -> "Something unexpected happened"
            else -> "Error: $statusCode"
        }
        Log.e("LOGIN_ERROR", errorMessage, e)
    }


    private fun validateEmail(email: String): Boolean {
        return android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()
    }

    private fun validatePassword(password: String): Boolean {
        return password.length >= 6
    }

}