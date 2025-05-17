package com.hoan.client.adapter

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView
import com.hoan.client.databinding.ItemProductBinding
import com.hoan.client.model.Product

class ProductAdapter(
    private val items: List<Product>
) : RecyclerView.Adapter<ProductAdapter.VH>() {

    inner class VH(val binding: ItemProductBinding)
        : RecyclerView.ViewHolder(binding.root)

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): VH {
        val binding = ItemProductBinding.inflate(
            LayoutInflater.from(parent.context),
            parent, false
        )
        return VH(binding)
    }

    override fun onBindViewHolder(holder: VH, position: Int) {
        val item = items[position]
        holder.binding.ivProduct.setImageResource(item.imageRes)
        holder.binding.tvName.text = item.name
        holder.binding.tvDetail.text = item.detail
        holder.binding.tvPrice.text = item.price
        holder.binding.btnAdd.setOnClickListener {

        }
    }

    override fun getItemCount() = items.size
}