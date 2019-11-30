package com.example.vantran.drinkshop.Utils;

import android.support.v7.widget.RecyclerView;

/**
 * Created by vandongluong on 10/22/18.
 */

public interface RecyclerItemTouchHelperListenner {
    void onSwiped(RecyclerView.ViewHolder viewHolder, int direction, int position);
}
