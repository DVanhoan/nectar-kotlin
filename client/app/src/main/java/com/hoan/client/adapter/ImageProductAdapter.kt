package com.hoan.client.adapter

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView
import com.hoan.client.databinding.ItemImageBinding
import com.hoan.client.model.Banner
import com.hoan.client.model.Image

class ImageProductAdapter(
    private val items: List<Image>
) : RecyclerView.Adapter<ImageProductAdapter.VH>() {

    inner class VH(val binding: ItemImageBinding) : RecyclerView.ViewHolder(binding.root)

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int) =
        VH(ItemImageBinding.inflate(LayoutInflater.from(parent.context), parent, false))

    override fun onBindViewHolder(holder: VH, position: Int) {
        val item = items[position]
        holder.binding.ivImage.setImageResource(item.imageRes)
    }
    override fun getItemCount() = items.size
}
