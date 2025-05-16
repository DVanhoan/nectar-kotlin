package com.hoan.client.adapter

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.recyclerview.widget.RecyclerView
import com.hoan.client.databinding.ItemCategoryBinding
import com.hoan.client.model.Category

class CategoryAdapter(
    private val items: List<Category>,
    private val onClick: (Category) -> Unit
) : RecyclerView.Adapter<CategoryAdapter.VH>() {

    inner class VH(private val binding: ItemCategoryBinding) : RecyclerView.ViewHolder(binding.root) {
        init {
            binding.root.setOnClickListener {
                onClick(items[adapterPosition])
            }
        }
        fun bind(cat: Category) {
            binding.tvTitle.text = cat.title
            binding.ivIcon.setImageResource(cat.imageRes)
            binding.cardContainer.setCardBackgroundColor(
                ContextCompat.getColor(binding.root.context, cat.bgColorRes)
            )
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): VH {
        val inflater = LayoutInflater.from(parent.context)
        val binding = ItemCategoryBinding.inflate(inflater, parent, false)
        return VH(binding)
    }

    override fun onBindViewHolder(holder: VH, position: Int) {
        holder.bind(items[position])
    }

    override fun getItemCount() = items.size
}
