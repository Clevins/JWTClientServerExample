/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* global user_id */

if (typeof(user_id) !== 'undefined') {}

$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results === null) {
        return null;
    }
    return decodeURI(results[1]) || 0;
};

$(function () {
    $("#").click(function () {
        alert("Called");
    });
});

$(document).ready(function () {
    
    var sPath = window.location.pathname;
    var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
    if(sPage === "home.php"){
        ajaxLoadData();
        ajaxLoadTags();
        ajaxSearch();
    }
    else if(sPage  === "book.php"){
        ajaxLoadBook($.urlParam('id'));
        ajaxLoadSellers($.urlParam('id'),user_id);
    } else if(sPage  === "profile.php"){
        ajaxLoadProfile(user_id);
    } 
});

function ajaxLoadData() {

    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "getAllBooks"}, // or function=two if you want the other to be called
        dataType: "html",
        success: function (result) {
            $("#products").html(result);
        }

    });

}

function ajaxLoadTags() {
    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "getAllTags"}, // or function=two if you want the other to be called
        dataType: "html",
        success: function (result) {
            $("#tags").html(result);
        }

    });
}

function ajaxLoadBook(id) {
    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "getBook", bookId: id}, // or function=two if you want the other to be called
        dataType: "html",
        success: function (result) {
            $("#book").html(result);
        }
    });
}

function ajaxLoadSellers(id,user_id) {
    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "getSellers", bookId: id , user_id: user_id}, // or function=two if you want the other to be called
        dataType: "html",
        success: function (result) {
            $("#sellers").html(result);
        }
    });
}

function ajaxSearch() {
    var searchResults = [];
    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "searchTitles"},
        success: function (result) {
            var jsonData = JSON.parse(result);
            searchResults = [];
            for (var i = 0; i < jsonData.length; i++) {
                searchResults.push(['' + jsonData[i].title] + '');
            }
            $("#search").autocomplete({
                source: searchResults,
                select: function (event, ui) {
                    seachData = ui.item.value;
                }
            });
        }

    });
}

function ajaxLoadProfile(user_id) {

    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "getProfile" , user_id: user_id}, // or function=two if you want the other to be called
        dataType: "html",
        success: function (result) {
            var output = $.parseJSON(result);
            $("#profile").html(output[0]);
            $("#mybooks").html(output[1]);
            $("#history").html(output[2]);
            $("#wishlist").html(output[3]);
            $("#booksLoan").html(output[4]);
        }

    });
}

function ajaxAddWishlist() {
    var userId = user_id;
    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "addWishlist", bookId: $.urlParam('id'), userId: userId},
        success: function (result) {
            alert(result);
            $("#addWishlist").popover(result);
            $("#addWishlist").html("Added to Wishlist");
            $("#addWishlist").prop("disabled", true);
        }
    });
}

function ajaxRemoveWishlist() {
    
    $.ajax({
        type: "POST",
        url: "php/loadHomeData.php",
        data: {data: "removeWishlist", bookId: $.urlParam('id'), userId: user_id},
        success: function (result) {
            alert(result);
            $("#addWishlist").popover(result);
            $("#addWishlist").html("Added to Wishlist");
            $("#addWishlist").prop("disabled", true);
        }
    });
}
