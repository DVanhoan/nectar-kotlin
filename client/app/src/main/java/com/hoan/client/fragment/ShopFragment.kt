package com.hoan.client.fragment

import android.graphics.Rect
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import androidx.viewpager2.widget.CompositePageTransformer
import androidx.viewpager2.widget.MarginPageTransformer
import com.hoan.client.R
import com.hoan.client.adapter.BannerAdapter
import com.hoan.client.adapter.ProductAdapter
import com.hoan.client.databinding.FragmentShopBinding
import com.hoan.client.model.Banner
import com.hoan.client.model.Product

class ShopFragment : Fragment(R.layout.fragment_shop) {
    private lateinit var binding: FragmentShopBinding

    private val slideHandler = android.os.Handler()
    private var bannerIndex = 0
    private lateinit var banners: List<Banner>

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentShopBinding.inflate(inflater, container, false)

        banners = listOf(
            Banner(R.drawable.veggies_banner1, "Fresh Vegetables", "Get Up To 40% OFF"),
            Banner(R.drawable.fruit_banner2, "Organic Fruits", "Summer Sale 30% OFF"),
            Banner(R.drawable.dairy_banner3, "Dairy Products", "Buy 2 Get 1 Free")
        )

        val bannerAdapter = BannerAdapter(banners)
        binding.bannerViewPager.adapter = bannerAdapter

        val transformer = CompositePageTransformer().apply {
            addTransformer(MarginPageTransformer(40))
            addTransformer { page, position ->
                val r = 1 - Math.abs(position)
                page.scaleY = 0.85f + r * 0.15f
            }
        }
        binding.bannerViewPager.setPageTransformer(transformer)



        val list = listOf(
            Product(R.drawable.ic_banana, "Organic Bananas", "7pcs, Priceg", "$4.99"),
            Product(R.drawable.fruit_banner2, "Red Apple", "1kg, Priceg", "$4.99"),
            Product(R.drawable.dairy_banner3, "Fresh Milk", "1L, Priceg", "$4.99"),
            Product(R.drawable.veggies_banner1, "Organic Bananas", "7pcs, Priceg", "$4.99"),
            Product(R.drawable.fruit_banner2, "Red Apple", "1kg, Priceg", "$4.99"),
        )

        val productAdapter = ProductAdapter(list)

        binding.rvExclusive.apply {
            layoutManager = LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false)
            this.adapter = productAdapter
            addItemDecoration(HorizontalSpaceItemDecoration(16))
        }


        val selling = listOf(
            Product(R.drawable.ic_banana, "Organic Bananas", "7pcs, Priceg", "$4.99"),
            Product(R.drawable.fruit_banner2, "Red Apple", "1kg, Priceg", "$4.99"),
            Product(R.drawable.dairy_banner3, "Fresh Milk", "1L, Priceg", "$4.99"),
            Product(R.drawable.veggies_banner1, "Organic Bananas", "7pcs, Priceg", "$4.99"),
            Product(R.drawable.fruit_banner2, "Red Apple", "1kg, Priceg", "$4.99"),
        )


        val sellingAdapter = ProductAdapter(selling)

        binding.rvSelling.apply {
            layoutManager = LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false)
            this.adapter = sellingAdapter
            addItemDecoration(HorizontalSpaceItemDecoration(16))
        }


        return binding.root
    }

    private val slideRunnable = object : Runnable {
        override fun run() {
            if (banners.isNotEmpty()) {
                bannerIndex = (bannerIndex + 1) % banners.size
                binding.bannerViewPager.setCurrentItem(bannerIndex, true)
                slideHandler.postDelayed(this, 5000)
            }
        }
    }

    override fun onResume() {
        super.onResume()
        slideHandler.postDelayed(slideRunnable, 3000)
    }

    override fun onPause() {
        super.onPause()
        slideHandler.removeCallbacks(slideRunnable)
    }



    class HorizontalSpaceItemDecoration(private val space: Int) : RecyclerView.ItemDecoration() {
        override fun getItemOffsets(
            outRect: Rect, view: View, parent: RecyclerView, state: RecyclerView.State
        ) {
            val pos = parent.getChildAdapterPosition(view)
            if (pos == 0) {
                outRect.left = space
            }
            outRect.right = space
        }
    }

    companion object {
        fun newInstance() = ShopFragment()
    }
}