package com.hoan.client

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.facebook.CallbackManager
import com.facebook.FacebookCallback
import com.facebook.FacebookException
import com.facebook.FacebookSdk
import com.facebook.appevents.AppEventsLogger
import com.facebook.login.LoginManager
import com.facebook.login.LoginResult
import com.hoan.client.databinding.ActivitySigninBinding
import com.hoan.client.network.RetrofitInstance
import com.hoan.client.network.RetrofitInstance.authService
import com.hoan.client.network.dto.FacebookLoginRequest
import com.hoan.client.network.dto.LoginResponse
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import org.json.JSONObject
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class SignInActivity : AppCompatActivity() {

    private lateinit var binding: ActivitySigninBinding
    private lateinit var callbackManager: CallbackManager

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        binding = ActivitySigninBinding.inflate(layoutInflater)
        setContentView(binding.root)

        FacebookSdk.sdkInitialize(applicationContext)
        AppEventsLogger.activateApp(application)
        callbackManager = CallbackManager.Factory.create()


        binding.btnFacebook.setOnClickListener {
            LoginManager.getInstance().logInWithReadPermissions(
                this,
                listOf("email", "public_profile")
            )
        }

        LoginManager.getInstance().registerCallback(callbackManager,
            object : FacebookCallback<LoginResult> {
                override fun onSuccess(result: LoginResult) {
                    val fbToken = result.accessToken.token
                    Log.d("FBLogin", "Token: $fbToken")
                    sendTokenToBackend(fbToken)
                }

                override fun onCancel() {
                    Log.d("FBLogin", "Login cancelled by user")
                }

                override fun onError(error: FacebookException) {
                    Log.e("FBLogin", "Error: ${error.message}")
                }
            }
        )
    }
    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        callbackManager.onActivityResult(requestCode, resultCode, data)
    }

    private fun sendTokenToBackend(fbToken : String) {
        val req = FacebookLoginRequest(fbToken)

        authService.facebookLogin(req).enqueue(object : Callback<LoginResponse> {
            override fun onResponse(call: Call<LoginResponse>, response: Response<LoginResponse>) {
                if (response.isSuccessful && response.body() != null) {
                    val loginRes = response.body()!!
                    RetrofitInstance.setToken(loginRes.accessToken)

                    Toast.makeText(this@SignInActivity, "Welcome, ${loginRes.user.name}", Toast.LENGTH_SHORT).show()
                     startActivity(Intent(this@SignInActivity, MainActivity::class.java))
                     finish()
                } else {
                    Log.e("API", "Login failed: ${response.code()}")
                    Toast.makeText(this@SignInActivity, "Backend login failed", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<LoginResponse>, t: Throwable) {
                Log.e("API", "Network error: ${t.message}")
                Toast.makeText(this@SignInActivity, "Network error", Toast.LENGTH_SHORT).show()
            }
        })
    }

}


