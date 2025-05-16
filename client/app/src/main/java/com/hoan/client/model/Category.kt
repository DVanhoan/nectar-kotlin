package com.hoan.client.model

import androidx.annotation.ColorRes
import androidx.annotation.DrawableRes

data class Category(
    val title: String,
    @DrawableRes val imageRes: Int,
    @ColorRes val bgColorRes: Int
)

