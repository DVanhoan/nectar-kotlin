package com.hoan.client

import android.content.Intent
import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.hoan.client.databinding.ActivityNumberBinding
import com.msg91.sendotp.OTPWidget
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext

class SentOTPActivity : AppCompatActivity() {

    private lateinit var binding: ActivityNumberBinding

    private val widgetId = "35657463484b313430353033"
    private val tokenAuth = "452231TefRSj2o682bf402P1"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityNumberBinding.inflate(layoutInflater)
        setContentView(binding.root)

        binding.imgBack.setOnClickListener {
            onBackPressedDispatcher.onBackPressed()
        }

        binding.tvNext.setOnClickListener {
            val phone = binding.etPhone.text.toString().trim()
            if (phone.isEmpty()) {
                Toast.makeText(this, "Vui lòng nhập số điện thoại", Toast.LENGTH_SHORT).show()
            } else {
                sendOtp("+$phone")
            }
        }
    }

    private fun sendOtp(mobile: String) {
        lifecycleScope.launchWhenStarted {
            try {
                val result = withContext(Dispatchers.IO) {
                    OTPWidget.sendOTP(widgetId, tokenAuth, mobile)
                }
                val reqId = parseRequestId(result)

                val intent = Intent(this@SentOTPActivity, VerifyOtpActivity::class.java)
                intent.putExtra("EXTRA_REQ_ID", reqId)
                startActivity(intent)

            } catch (e: Exception) {
                Toast.makeText(this@SentOTPActivity, "Gửi OTP thất bại: ${e.message}", Toast.LENGTH_LONG).show()
            }
        }
    }


    private fun parseRequestId(result: String): String {
        return if (result.contains("request_id")) {
            Regex("\"request_id\"\\s*:\\s*\"([^\"]+)\"")
                .find(result)?.groups?.get(1)?.value
                ?: result
        } else {
            result
        }
    }
}
