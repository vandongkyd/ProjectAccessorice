package com.example.khoavx.accessoriceshop.Utils;

import android.graphics.Canvas;
import androidx.recyclerview.widget.RecyclerView;
import androidx.recyclerview.widget.ItemTouchHelper;
import android.view.View;

import com.example.khoavx.accessoriceshop.Apdater.CartAdapter;
import com.example.khoavx.accessoriceshop.Apdater.FavoriteAdapter;

/**
 * Created by vandongluong on 10/22/18.
 */

public class RecyclerItemTouchHelper extends ItemTouchHelper.SimpleCallback {

    RecyclerItemTouchHelperListenner listenner;

    public RecyclerItemTouchHelper(int dragDirs, int swipeDirs, RecyclerItemTouchHelperListenner listenner) {
        super(dragDirs, swipeDirs);
        this.listenner = listenner;
    }

    @Override
    public boolean onMove(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder, RecyclerView.ViewHolder target) {
        return true;
    }

    @Override
    public void onSwiped(RecyclerView.ViewHolder viewHolder, int direction) {
        if (listenner != null){
            listenner.onSwiped(viewHolder, direction, viewHolder.getAdapterPosition());
        }

    }

    @Override
    public void clearView(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder) {
        if (viewHolder instanceof FavoriteAdapter.ViewHolder) {
            View foregroundView = ((FavoriteAdapter.ViewHolder) viewHolder).view_foreground;
            getDefaultUIUtil().clearView(foregroundView);
        }else if (viewHolder instanceof CartAdapter.ViewHolder){
            View foregroundView = ((CartAdapter.ViewHolder) viewHolder).view_foreground;
            getDefaultUIUtil().clearView(foregroundView);
        }
    }

    @Override
    public int convertToAbsoluteDirection(int flags, int layoutDirection) {
        return super.convertToAbsoluteDirection(flags, layoutDirection);
    }

    @Override
    public void onSelectedChanged(RecyclerView.ViewHolder viewHolder, int actionState) {
        if (viewHolder != null){
            if (viewHolder instanceof FavoriteAdapter.ViewHolder) {
                View foregroundView = ((FavoriteAdapter.ViewHolder) viewHolder).view_foreground;
                getDefaultUIUtil().onSelected(foregroundView);
            }else if (viewHolder instanceof CartAdapter.ViewHolder){
                View foregroundView = ((CartAdapter.ViewHolder) viewHolder).view_foreground;
                getDefaultUIUtil().onSelected(foregroundView);
            }
        }
    }

    @Override
    public void onChildDraw(Canvas c, RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder, float dX, float dY, int actionState, boolean isCurrentlyActive) {
        if (viewHolder instanceof FavoriteAdapter.ViewHolder) {
            View foregroundView = ((FavoriteAdapter.ViewHolder)viewHolder).view_foreground;
            getDefaultUIUtil().onDraw(c,recyclerView,foregroundView,dX,dY,actionState,isCurrentlyActive);
        }else if (viewHolder instanceof CartAdapter.ViewHolder){
            View foregroundView = ((CartAdapter.ViewHolder)viewHolder).view_foreground;
            getDefaultUIUtil().onDraw(c,recyclerView,foregroundView,dX,dY,actionState,isCurrentlyActive);
        }
    }

    @Override
    public void onChildDrawOver(Canvas c, RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder, float dX, float dY, int actionState, boolean isCurrentlyActive) {

        if (viewHolder instanceof FavoriteAdapter.ViewHolder) {
            View foregroundView = ((FavoriteAdapter.ViewHolder)viewHolder).view_foreground;
            getDefaultUIUtil().onDrawOver(c,recyclerView,foregroundView,dX,dY,actionState,isCurrentlyActive);
        }else if (viewHolder instanceof CartAdapter.ViewHolder){
            View foregroundView = ((CartAdapter.ViewHolder)viewHolder).view_foreground;
            getDefaultUIUtil().onDrawOver(c,recyclerView,foregroundView,dX,dY,actionState,isCurrentlyActive);
        }
    }
}
