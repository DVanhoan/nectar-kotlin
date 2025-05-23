package com.hoan.client

import android.content.Intent
import android.graphics.Color
import android.os.Bundle
import android.text.SpannableString
import android.text.Spanned
import android.text.TextPaint
import android.text.method.LinkMovementMethod
import android.text.style.ClickableSpan
import android.view.View
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.hoan.client.databinding.ActivitySignupBinding

class SignUpActivity : AppCompatActivity() {

    private lateinit var binding: ActivitySignupBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivitySignupBinding.inflate(layoutInflater)
        setContentView(binding.root)


        termsText(binding)
        binding.btnSignUp.setOnClickListener {
            val username = binding.etUserName.text.toString()
            val email = binding.etEmail.text.toString()
            val password = binding.etPassword.text.toString()

            if (validateUsername(username) && validateEmail(email) && validatePassword(password)) {
                Toast.makeText(this, "Sign up successful", Toast.LENGTH_SHORT).show()
            } else {
                if (!validateUsername(username)) {
                    binding.etUserName.error = "Username must be at least 3 characters"
                }
                if (!validateEmail(email)) {
                    binding.etEmail.error = "Invalid email format"
                }
                if (!validatePassword(password)) {
                    binding.etPassword.error = "Password must be at least 6 characters"
                }
            }
        }
        binding.linkLogin.setOnClickListener {
            startActivity(Intent(this, LoginActivity::class.java))
            finish()
        }
    }

    private fun validateEmail(email: String): Boolean {
        return android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()
    }

    private fun validatePassword(password: String): Boolean {
        return password.length >= 6
    }

    private fun validateUsername(username: String): Boolean {
        return username.length >= 3
    }





    private fun termsText(binding: ActivitySignupBinding) {
        val fullText = "By continuing you agree to our Terms of Service and Privacy Policy."
        val spannable = SpannableString(fullText)

        val termsStart = fullText.indexOf("Terms of Service")
        val termsEnd = termsStart + "Terms of Service".length

        val privacyStart = fullText.indexOf("Privacy Policy")
        val privacyEnd = privacyStart + "Privacy Policy".length


        val termsClickable = object : ClickableSpan() {
            override fun onClick(widget: View) {
                Toast.makeText(widget.context, "Terms clicked", Toast.LENGTH_SHORT).show()
                // Example: open link
                // val browserIntent = Intent(Intent.ACTION_VIEW, Uri.parse("https://yourdomain.com/terms"))
                // widget.context.startActivity(browserIntent)
            }

            override fun updateDrawState(ds: TextPaint) {
                super.updateDrawState(ds)
                ds.color = Color.parseColor("#53B175")
                ds.isUnderlineText = false
            }
        }


        val privacyClickable = object : ClickableSpan() {
            override fun onClick(widget: View) {
                Toast.makeText(widget.context, "Privacy clicked", Toast.LENGTH_SHORT).show()
            }

            override fun updateDrawState(ds: TextPaint) {
                super.updateDrawState(ds)
                ds.color = Color.parseColor("#53B175")
                ds.isUnderlineText = false
            }
        }

        spannable.setSpan(
            termsClickable,
            termsStart,
            termsEnd,
            Spanned.SPAN_EXCLUSIVE_EXCLUSIVE
        )
        spannable.setSpan(
            privacyClickable,
            privacyStart,
            privacyEnd,
            Spanned.SPAN_EXCLUSIVE_EXCLUSIVE
        )

        binding.termsText.text = spannable
        binding.termsText.movementMethod = LinkMovementMethod.getInstance()
        binding.termsText.highlightColor = Color.TRANSPARENT
    }

}