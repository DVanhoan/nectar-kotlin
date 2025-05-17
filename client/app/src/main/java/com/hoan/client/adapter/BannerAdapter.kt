package com.hoan.client.adapter

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView
import com.hoan.client.databinding.ItemBannerBinding
import com.hoan.client.model.Banner

class BannerAdapter(
    private val items: List<Banner>
) : RecyclerView.Adapter<BannerAdapter.VH>() {
    inner class VH(val binding: ItemBannerBinding) : RecyclerView.ViewHolder(binding.root)
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int) =
        VH(ItemBannerBinding.inflate(LayoutInflater.from(parent.context), parent, false))
    override fun onBindViewHolder(holder: VH, position: Int) {
        val item = items[position]
        holder.binding.ivBanner.setImageResource(item.imageRes)
        holder.binding.tvTitle.text = item.title
        holder.binding.tvSubtitle.text = item.subtitle
    }
    override fun getItemCount() = items.size
}
