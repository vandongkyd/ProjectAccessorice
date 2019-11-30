package com.example.vantran.drinkshop.Model;

/**
 * Created by vandongluong on 10/20/18.
 */

public class Banner {
    public String id ;
    private String banner_name ;
    private String banner_img ;
    private String category_id ;
    private String product_id ;
    private String sort_no ;
    private String banner_description ;
    private String banner_status ;
    private String banner_date_start ;
    private String banner_date_end ;
    private String del_flg ;
    private String created ;
    private String updated ;

    public Banner() {
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getBanner_name() {
        return banner_name;
    }

    public void setBanner_name(String banner_name) {
        this.banner_name = banner_name;
    }

    public String getBanner_img() {
        return banner_img;
    }

    public void setBanner_img(String banner_img) {
        this.banner_img = banner_img;
    }

    public String getCategory_id() {
        return category_id;
    }

    public void setCategory_id(String category_id) {
        this.category_id = category_id;
    }

    public String getProduct_id() {
        return product_id;
    }

    public void setProduct_id(String product_id) {
        this.product_id = product_id;
    }

    public String getSort_no() {
        return sort_no;
    }

    public void setSort_no(String sort_no) {
        this.sort_no = sort_no;
    }

    public String getBanner_description() {
        return banner_description;
    }

    public void setBanner_description(String banner_description) {
        this.banner_description = banner_description;
    }

    public String getBanner_status() {
        return banner_status;
    }

    public void setBanner_status(String banner_status) {
        this.banner_status = banner_status;
    }

    public String getBanner_date_start() {
        return banner_date_start;
    }

    public void setBanner_date_start(String banner_date_start) {
        this.banner_date_start = banner_date_start;
    }

    public String getBanner_date_end() {
        return banner_date_end;
    }

    public void setBanner_date_end(String banner_date_end) {
        this.banner_date_end = banner_date_end;
    }

    public String getDel_flg() {
        return del_flg;
    }

    public void setDel_flg(String del_flg) {
        this.del_flg = del_flg;
    }

    public String getCreated() {
        return created;
    }

    public void setCreated(String created) {
        this.created = created;
    }

    public String getUpdated() {
        return updated;
    }

    public void setUpdated(String updated) {
        this.updated = updated;
    }
}
