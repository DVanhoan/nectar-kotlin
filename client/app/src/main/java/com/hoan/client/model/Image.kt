package com.hoan.client.model

import android.os.Parcelable
import kotlinx.parcelize.Parcelize

@Parcelize
data class Image(
    val imageRes: Int,
    val isPrimary: Boolean
) : Parcelable
