package com.hoan.client

import android.content.Context
import android.content.SharedPreferences
import android.os.Bundle
import android.view.View
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.hoan.client.databinding.ActivityMainBinding
import com.hoan.client.fragment.AccountFragment
import com.hoan.client.fragment.CartFragment
import com.hoan.client.fragment.ExploreFragment
import com.hoan.client.fragment.FavouriteFragment
import com.hoan.client.fragment.ShopFragment
import com.hoan.client.network.RetrofitInstance

class MainActivity : AppCompatActivity() {

    private lateinit var binding: ActivityMainBinding
    private lateinit var sharedPreferences: SharedPreferences
    private val sharedPrefName = "user_shared_preference"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)

        sharedPreferences = getSharedPreferences(sharedPrefName, Context.MODE_PRIVATE)
        RetrofitInstance.setToken(sharedPreferences.getString("access_token", "") ?: "")

        replaceFragment(ShopFragment.newInstance(), TAG_SHOP)

        binding.bottomNavigation.setOnItemSelectedListener { item ->
            when (item.itemId) {
                R.id.shop -> {
                    replaceFragment(ShopFragment.newInstance(), TAG_SHOP)
                    true
                }
                R.id.explore -> {
                    replaceFragment(ExploreFragment.newInstance(), TAG_EXPLORE)
                    true
                }
                R.id.cart -> {
                    replaceFragment(CartFragment.newInstance(), TAG_CART)
                    true
                }
                R.id.favourite -> {
                    replaceFragment(FavouriteFragment.newInstance(), TAG_FAVOURITE)
                    true
                }
                R.id.account -> {
                    replaceFragment(AccountFragment.newInstance(), TAG_ACCOUNT)
                    true
                }
                else -> false
            }
        }
    }

    private fun replaceFragment(fragment: Fragment, tag: String) {
        binding.bottomNavigation.visibility = View.VISIBLE

        val tx = supportFragmentManager.beginTransaction()
        supportFragmentManager.fragments.forEach { tx.hide(it) }
        supportFragmentManager.findFragmentByTag(tag)?.let {
            tx.show(it)
        } ?: run {
            tx.add(R.id.nav_host_fragment, fragment, tag)
        }
        tx.commit()
    }


    companion object {
        private const val TAG_SHOP = "SHOP"
        private const val TAG_EXPLORE = "EXPLORE"
        private const val TAG_CART = "CART"
        private const val TAG_FAVOURITE = "FAVOURITE"
        private const val TAG_ACCOUNT = "ACCOUNT"
    }
}
