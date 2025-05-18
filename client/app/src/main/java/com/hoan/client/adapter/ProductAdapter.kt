package com.hoan.client.adapter

import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.Toast
import androidx.recyclerview.widget.RecyclerView
import com.hoan.client.ProductActivity
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

        for (i in item.images.indices) {
            if (item.images[i].isPrimary) {
                holder.binding.ivProduct.setImageResource(item.images[i].imageRes)
                break
            }
        }

        holder.binding.tvName.text = item.name
        holder.binding.tvDetail.text = item.detail
        holder.binding.tvPrice.text = item.price
        holder.binding.btnAdd.setOnClickListener {
            Toast.makeText(
                holder.itemView.context,
                "${item.name} added to cart",
                Toast.LENGTH_SHORT
            ).show()
        }

        holder.binding.root.setOnClickListener {
            val intent = Intent(holder.itemView.context, ProductActivity::class.java)
            intent.putExtra("product", item)
            holder.itemView.context.startActivity(intent)
        }
    }

    override fun getItemCount() = items.size
}