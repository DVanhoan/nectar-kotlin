package com.hoan.client.fragment

import android.os.Bundle
import android.view.View
import android.widget.Toast
import androidx.core.widget.doOnTextChanged
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.GridLayoutManager
import com.hoan.client.R
import com.hoan.client.adapter.CategoryAdapter
import com.hoan.client.databinding.FragmentExploreBinding
import com.hoan.client.model.Category

class ExploreFragment : Fragment(R.layout.fragment_explore) {

    private var _binding: FragmentExploreBinding? = null
    private val binding get() = _binding!!

    private lateinit var adapter: CategoryAdapter

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        _binding = FragmentExploreBinding.bind((view))

        val categories = listOf(
            Category("Fresh Fruits & Vegetable", R.drawable.img_fruits, R.color.bg_green_light),
            Category("Cooking Oil & Ghee", R.drawable.img_oil, R.color.bg_yellow_light),
            Category("Meat & Fish", R.drawable.img_meat, R.color.bg_pink_light),
            Category("Bakery & Snacks", R.drawable.img_bakery, R.color.bg_purple_light),
            Category("Dairy & Eggs", R.drawable.img_dairy, R.color.bg_yellow_pale),
            Category("Beverages", R.drawable.img_beverage, R.color.bg_blue_pale)
        )


        adapter = CategoryAdapter(categories) { category ->
            Toast.makeText(requireContext(), "Clicked on ${category.title}", Toast.LENGTH_SHORT).show()
        }
        binding.rvCategories.layoutManager = GridLayoutManager(requireContext(), 2)
        binding.rvCategories.adapter = adapter

        binding.etSearch.doOnTextChanged { text, _, _, _ ->
            val filtered = if (text.isNullOrBlank()) {
                categories
            } else {
                categories.filter { it.title.contains(text, ignoreCase = true) }
            }
            adapter = CategoryAdapter(filtered) {
                Toast.makeText(requireContext(), "Clicked on ${it.title}", Toast.LENGTH_SHORT).show()
            }
            binding.rvCategories.adapter = adapter
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }

    companion object {
        fun newInstance() = ExploreFragment()
    }
}
