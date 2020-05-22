package com.example.khoavx.accessoriceshop.Utils;

import androidx.recyclerview.widget.RecyclerView;


public interface RecyclerItemTouchHelperListenner {
    void onSwiped(RecyclerView.ViewHolder viewHolder, int direction, int position);
}
