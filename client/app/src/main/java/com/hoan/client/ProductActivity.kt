package com.hoan.client

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.viewpager2.widget.CompositePageTransformer
import androidx.viewpager2.widget.MarginPageTransformer
import com.hoan.client.adapter.ImageProductAdapter
import com.hoan.client.databinding.ActivityProductBinding
import com.hoan.client.model.Product

class ProductActivity : AppCompatActivity() {

    private lateinit var binding : ActivityProductBinding

    override  fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityProductBinding.inflate(layoutInflater)
        setContentView(binding.root)

        val product = intent.getParcelableExtra<Product>("product")

        val imageProductAdapter = ImageProductAdapter(product?.images ?: emptyList())

        binding.productImages.adapter = imageProductAdapter

        val transformer = CompositePageTransformer().apply {
            addTransformer(MarginPageTransformer(40))
            addTransformer { page, position ->
                val r = 1 - Math.abs(position)
                page.scaleY = 0.85f + r * 0.15f
            }
        }
        binding.productImages.setPageTransformer(transformer)

        binding.productName.text = product?.name
        binding.productPrice.text = product?.price
        binding.tvProductDetail.text = product?.detail
        binding.imgBack.setOnClickListener {
            onBackPressedDispatcher.onBackPressed()
        }
    }
}