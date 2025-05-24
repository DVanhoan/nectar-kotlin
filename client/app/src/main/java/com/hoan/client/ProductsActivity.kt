package com.hoan.client

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.GridLayoutManager
import com.hoan.client.adapter.ProductAdapter
import com.hoan.client.databinding.ActivityProductsBinding
import com.hoan.client.model.Image
import com.hoan.client.model.Product

class ProductsActivity : AppCompatActivity() {

    private lateinit var binding: ActivityProductsBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityProductsBinding.inflate(layoutInflater)
        setContentView(binding.root)

        val imageProduct1 = listOf(
            Image(R.drawable.ic_banana,true),
            Image(R.drawable.fruit_banner2,false),
            Image(R.drawable.dairy_banner3,false),
        )

        val imageProduct2 = listOf(
            Image(R.drawable.ic_banana,false),
            Image(R.drawable.fruit_banner2,true),
            Image(R.drawable.dairy_banner3,false),
        )


        val products = listOf(
            Product(11, imageProduct1, "Beef Bone", "7kg, Priceg", "$4.99"),
            Product(12, imageProduct2, "Broiler Chicken", "1kg, Priceg", "$4.99"),
            Product(13, imageProduct1, "Organic Bananas", "7pcs, Priceg", "$4.99"),
        )

        val productAdapter = ProductAdapter(products)

        binding.rvProducts.apply {
            layoutManager = GridLayoutManager(this@ProductsActivity, 2)
            this.adapter = productAdapter
        }

    }

}