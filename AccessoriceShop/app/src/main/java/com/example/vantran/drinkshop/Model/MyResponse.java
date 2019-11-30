package com.example.vantran.drinkshop.Model;

import java.util.List;

/**
 * Created by vandongluong on 10/29/18.
 */

public class MyResponse {
    public long multicast_id;
    public int success, failure, canonical_ids;
    public List<Result> results;
}
