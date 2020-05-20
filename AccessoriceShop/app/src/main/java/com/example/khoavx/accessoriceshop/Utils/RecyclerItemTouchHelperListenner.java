package com.example.khoavx.accessoriceshop.Utils;

import androidx.recyclerview.widget.RecyclerView;

/**
 * Created by vandongluong on 10/22/18.
 */

public interface RecyclerItemTouchHelperListenner {
    void onSwiped(RecyclerView.ViewHolder viewHolder, int direction, int position);
}
