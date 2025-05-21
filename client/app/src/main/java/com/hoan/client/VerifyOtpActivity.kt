package com.hoan.client

import android.content.Intent
import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.hoan.client.databinding.ActivityVerifyOtpBinding
import com.msg91.sendotp.OTPWidget
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext



class VerifyOtpActivity : AppCompatActivity() {

    private lateinit var binding: ActivityVerifyOtpBinding

    private val widgetId = "35657463484b313430353033"
    private val tokenAuth = "452231TefRSj2o682bf402P1"

    private lateinit var reqId: String

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityVerifyOtpBinding.inflate(layoutInflater)
        setContentView(binding.root)

        reqId = intent.getStringExtra("EXTRA_REQ_ID")
            ?: run {
                Toast.makeText(this, "Không tìm thấy reqId!", Toast.LENGTH_LONG).show()
                finish()
                return
            }

        setupUi()
    }

    private fun setupUi() {
        binding.imgSignIn.setOnClickListener {
            onBackPressedDispatcher.onBackPressed()
        }

        binding.tvNext.setOnClickListener {
            val otp = binding.etPhone.text.toString().trim()
            if (otp.length < 4) {
                Toast.makeText(this, "Vui lòng nhập đủ mã OTP", Toast.LENGTH_SHORT).show()
            } else {
                handleVerifyOtp(otp)
            }
        }


        binding.tvResendCode.setOnClickListener {
            handleRetryOtp()
        }
    }

    private fun handleVerifyOtp(otp: String) {
        lifecycleScope.launchWhenStarted {
            try {
                val result = withContext(Dispatchers.IO) {
                    OTPWidget.verifyOTP(widgetId, tokenAuth, reqId, otp)
                }
                Toast.makeText(this@VerifyOtpActivity, "Verify result: $result", Toast.LENGTH_LONG).show()
                intent = Intent(this@VerifyOtpActivity, MainActivity::class.java)

            } catch (e: Exception) {
                Toast.makeText(this@VerifyOtpActivity, "Error in VerifyOTP: ${e.message}", Toast.LENGTH_LONG).show()
            }
        }
    }

    private fun handleRetryOtp() {
        lifecycleScope.launchWhenStarted {
            try {
                val result = withContext(Dispatchers.IO) {
                    OTPWidget.retryOTP(widgetId, tokenAuth, reqId, 1)
                }
                Toast.makeText(this@VerifyOtpActivity, "Retry result: $result", Toast.LENGTH_LONG).show()
            } catch (e: Exception) {
                Toast.makeText(this@VerifyOtpActivity, "Error in RetryOTP: ${e.message}", Toast.LENGTH_LONG).show()
            }
        }
    }

    private fun getWidgetProcess() {
        lifecycleScope.launchWhenStarted {
            try {
                val widgetData = withContext(Dispatchers.IO) {
                    OTPWidget.getWidgetProcess(widgetId, tokenAuth)
                }
                Toast.makeText(this@VerifyOtpActivity, "Widget Data: $widgetData", Toast.LENGTH_LONG).show()
            } catch (e: Exception) {
                Toast.makeText(this@VerifyOtpActivity, "Error in GetWidgetData: ${e.message}", Toast.LENGTH_LONG).show()
            }
        }
    }
}
