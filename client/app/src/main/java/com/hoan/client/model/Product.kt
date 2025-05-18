package com.hoan.client.model

import android.os.Parcelable
import kotlinx.parcelize.Parcelize

@Parcelize
data class Product (
    val id: Int,
    val images: List<Image>,
    val name: String,
    val detail: String,
    val price: String
): Parcelable