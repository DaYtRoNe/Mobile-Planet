function ChangeView() {
    var signUpBox = document.getElementById("signupbox");
    var signInBox = document.getElementById("signinbox");

    signUpBox.classList.toggle("d-none");
    signInBox.classList.toggle("d-none");

}

function signUp() {

    var fn = document.getElementById("fname");
    var ln = document.getElementById("lname");
    var mail = document.getElementById("email");
    var pw = document.getElementById("password");
    var mb = document.getElementById("mobile");
    var g = document.getElementById("gender");

    var f = new FormData();
    f.append("fname", fn.value);
    f.append("lname", ln.value);
    f.append("email", mail.value);
    f.append("password", pw.value);
    f.append("mobile", mb.value);
    f.append("gender", g.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;

            if (t == "success") {

                document.getElementById("SUmsg").innerHTML = "account created successfully. please sign in..";
                document.getElementById("SUmsg").className = "alert alert-success";
                document.getElementById("SUmsgdiv").className = "d-block";

            } else {

                document.getElementById("SUmsg").innerHTML = t;
                document.getElementById("SUmsgdiv").className = "d-block";

            }
        }
    }

    r.open("POST", "signUpProcess.php", true);
    r.send(f);

}

function signIn() {
    var email = document.getElementById("SIemail").value;
    var password = document.getElementById("SIpassword").value;
    var rememberme = document.getElementById("rememberme").checked;

    var f = new FormData();
    f.append("e", email);
    f.append("p", password);
    f.append("r", rememberme);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t === "success") {
                window.location = "index.php";
            } else {
                document.getElementById("SImsg").innerHTML = t;
                document.getElementById("SImsgdiv").className = "d-block";
            }
        }
    }

    r.open("POST", "signInProcess.php", true);
    r.send(f);
}


function ChangeView2() {
    var forgotpassbox = document.getElementById("forgotpasswordbox");
    var newpassbox = document.getElementById("newpasswordbox");

    forgotpassbox.classList.toggle("d-none");
    newpassbox.classList.toggle("d-none");

}

function showPassword() {

    var sip = document.getElementById("SIpassword");
    var sipb = document.getElementById("SIpasswordb");

    if (sip.type == "password") {
        sip.type = "text";
        sipb.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    } else {
        sip.type = "password";
        sipb.innerHTML = '<i class="bi bi-eye"></i>';
    }

}

function AshowPassword() {

    var sip = document.getElementById("ASIpassword");
    var sipb = document.getElementById("ASIpasswordb");

    if (sip.type == "password") {
        sip.type = "text";
        sipb.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    } else {
        sip.type = "password";
        sipb.innerHTML = '<i class="bi bi-eye"></i>';
    }

}

function adminSignIn() {
    var email = document.getElementById("ASIemail");
    var password = document.getElementById("ASIpassword");

    var f = new FormData();
    f.append("e", email.value);
    f.append("p", password.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "adminDashboard.php";
            } else {
                document.getElementById("ASImsg").innerHTML = t;
                document.getElementById("ASImsgdiv").className = "d-block";
            }

        }
    }

    r.open("POST", "adminSignInProcess.php", true);
    r.send(f);
}

function showPassword1() {

    var np = document.getElementById("np");
    var npb = document.getElementById("npb");

    if (np.type == "password") {
        np.type = "text";
        npb.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    } else {
        np.type = "password";
        npb.innerHTML = '<i class="bi bi-eye"></i>';
    }

}

function showPassword2() {

    var rnp = document.getElementById("rnp");
    var rnpb = document.getElementById("rnpb");

    if (rnp.type == "password") {
        rnp.type = "text";
        rnpb.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    } else {
        rnp.type = "password";
        rnpb.innerHTML = '<i class="bi bi-eye"></i>';
    }

}

function forgotPassword() {

    var email = document.getElementById("forgotpwemail");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;

            if (t == "Email sent to your Email Address") {
                ChangeView2();
            } else {
                document.getElementById("FPmsg").innerHTML = t;
                document.getElementById("FPmsgdiv").className = "d-block";
            }

        }
    }

    r.open("GET", "forgotpasswordProcess.php?e=" + email.value, true);
    r.send();

}

function resetPassword() {

    var email = document.getElementById("forgotpwemail");
    var np = document.getElementById("np");
    var rnp = document.getElementById("rnp");
    var vc = document.getElementById("vc");

    var f = new FormData();
    f.append("e", email.value);
    f.append("np", np.value);
    f.append("rnp", rnp.value);
    f.append("vc", vc.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;

            if (t == "success") {

                // alert("Your password has been updated.");
                swal("Success!", "Your password has been updated.", "success");
                window.location.href = "signIn.php";

            } else {
                document.getElementById("SNPmsg").innerHTML = t;
                document.getElementById("SNPmsgdiv").className = "d-block";
            }
        }
    }

    r.open("POST", "resetPasswordProcess.php", true);
    r.send(f);

}

function signOut(){
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Sign Out?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                signOutConfirm();
            }
        });
}

function signOutConfirm() {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;

            if (t == "success") {
                window.location.reload();
            } else {
                // alert(t);
                swal("Oops!", "Something went wrong!", "error");
            }
        }
    }

    r.open("GET", "signoutProcess.php", true);
    r.send();
}

function showPassword3() {

    var pw = document.getElementById("pw");
    var pwb = document.getElementById("pwb");

    if (pw.type == "password") {
        pw.type = "text";
        pwb.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    } else {
        pw.type = "password";
        pwb.innerHTML = '<i class="bi bi-eye-fill"></i>';
    }

}

function updateProfile() {

    var profile_img = document.getElementById("profileImage");
    var first_name = document.getElementById("fname");
    var last_name = document.getElementById("lname");
    var mobile_no = document.getElementById("mobile");
    var password = document.getElementById("pw");
    var email_address = document.getElementById("email");
    var address_line_1 = document.getElementById("line1");
    var address_line_2 = document.getElementById("line2");
    var province = document.getElementById("province");
    var district = document.getElementById("district");
    var city = document.getElementById("city");
    var postal_code = document.getElementById("pc");

    var f = new FormData();
    f.append("img", profile_img.files[0]);
    f.append("fn", first_name.value);
    f.append("ln", last_name.value);
    f.append("mn", mobile_no.value);
    f.append("pw", password.value);
    f.append("ea", email_address.value);
    f.append("al1", address_line_1.value);
    f.append("al2", address_line_2.value);
    f.append("p", province.value);
    f.append("d", district.value);
    f.append("c", city.value);
    f.append("pc", postal_code.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                signOutConfirm();
            } else {
                // alert(t);
                swal("Oops!", t, "error", {
                    button: "OK",
                });
            }

        }
    }

    r.open("POST", "userProfileUpdateProcess.php", true);
    r.send(f);

}

function loadBrands() {

    var category = document.getElementById("category").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("brand").innerHTML = t;

        }
    }

    r.open("GET", "loadBrandProcess.php?c=" + category, true);
    r.send();

}

function loadModel() {

    var category = document.getElementById("category").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("model").innerHTML = t;

        }
    }

    r.open("GET", "loadModelProcess.php?m=" + category, true);
    r.send();

}

function loadsubcategory() {

    var category = document.getElementById("category").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("subcat").innerHTML = t;

        }
    }

    r.open("GET", "loadSubCategoryProcess.php?d=" + category, true);
    r.send();

}

function changeProductImage() {

    var images = document.getElementById("imageuploader");

    images.onchange = function () {

        var file_count = images.files.length;

        if (file_count <= 4) {

            for (var i = 0; i < file_count; i++) {
                var file = this.files[i];
                var url = window.URL.createObjectURL(file);
                document.getElementById("img" + i).src = url;
            }

        } else {
            // alert(file_count + " files uploaded. You are proceed to upload 04 or less than 04 images.");
            swal("Oh!", file_count + " files uploaded. You are proceed to upload 04 or less than 04 images.", "error", {
                button: "OK",
            });
        }

    }

}

function addProduct() {

    var subcat = document.getElementById("subcat");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");
    var condition = 0;
    if (document.getElementById("b").checked) {
        condition = 1;
    } else if (document.getElementById("u").checked) {
        condition = 2;
    } else if (document.getElementById("r").checked) {
        condition = 3;
    }
    var clr = document.getElementById("clr");
    var qty = document.getElementById("qty");
    var cost = document.getElementById("cost");
    var dwc = document.getElementById("dwc");
    var doc = document.getElementById("doc");
    var desc = document.getElementById("desc");
    var image = document.getElementById("imageuploader");

    var f = new FormData();
    f.append("subcat", subcat.value);
    f.append("b", brand.value);
    f.append("m", model.value);
    f.append("t", title.value);
    f.append("con", condition);
    f.append("col", clr.value);
    f.append("qty", qty.value);
    f.append("cost", cost.value);
    f.append("dwc", dwc.value);
    f.append("doc", doc.value);
    f.append("desc", desc.value);

    var file_count = image.files.length;
    for (var i = 0; i < file_count; i++) {
        f.append("img" + i, image.files[i]);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                window.location.reload();
            } else {
                // alert(t);
                swal("Oops!", t, "error", {
                    button: "OK",
                });
            }

        }
    }

    r.open("POST", "addProductProcess.php", true);
    r.send(f);

}

function clrup() {
    var clr = document.getElementById("clr_in");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                window.location.reload();
            } else {
                // alert(t);
                swal("Oops!", t, "error", {
                    button: "OK",
                });
            }

        }
    }

    r.open("GET", "addNewColor.php?d=" + clr.value, true);
    r.send();
}

function changeProductStatus(id) {

    var product_id = id;
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "activated" || t == "deactivated") {
                window.location.reload();
            } else {
                // alert(t);
                swal("Oops!", t, "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "changeProductStatusProcess.php?p=" + product_id, true);
    r.send();

}

// function sort(x) {

//     var search = document.getElementById("s");
//     var time = "0";

//     if (document.getElementById("n").checked) {
//         time = "1";
//     } else if (document.getElementById("o").checked) {
//         time = "2";
//     }

//     var price = "0";

//     if (document.getElementById("ph").checked) {
//         price = "1";
//     } else if (document.getElementById("pl").checked) {
//         price = "2";
//     }

//     var qty = "0";

//     if (document.getElementById("qh").checked) {
//         qty = "1";
//     } else if (document.getElementById("ql").checked) {
//         qty = "2";
//     }

//     var condition = "0";

//     if (document.getElementById("b").checked) {
//         condition = "1";
//     } else if (document.getElementById("u").checked) {
//         condition = "2";
//     } else if (document.getElementById("r").checked) {
//         condition = "3";
//     }

//     var f = new FormData();
//     f.append("s", search.value);
//     f.append("t", time);
//     f.append("p", price);
//     f.append("q", qty);
//     f.append("c", condition);
//     f.append("page", x);

//     var r = new XMLHttpRequest();

//     r.onreadystatechange = function () {
//         if (r.status == 200 && r.readyState == 4) {
//             var t = r.responseText;

//             document.getElementById("sort").innerHTML = t;

//         }
//     }

//     r.open("POST", "sortProcess.php", true);
//     r.send(f);

// }

function filter(y) {
    var search = document.getElementById("se");
    var sortBy = document.getElementById("sse");
    var conBy = document.getElementById("cse");


    var f = new FormData();
    f.append("se", search.value);
    f.append("sse", sortBy.value);
    f.append("cse", conBy.value);
    f.append("page", y);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "error") {
                // document.getElementById("popup-body").innerText = "Something Went Wrong!";
                // var myModal = new mdb.Modal(document.getElementById('popup'));
                // myModal.show();
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            } else {
                document.getElementById("sort").innerHTML = t;
            }


        }
    }

    r.open("POST", "sortProcess.php", true);
    r.send(f);

}

// function filter(y) {

//     var search = document.getElementById("se");
//     var time = "0";

//     if (document.getElementById("ne").checked) {
//         time = "1";
//     } else if (document.getElementById("ol").checked) {
//         time = "2";
//     }

//     var price = "0";

//     if (document.getElementById("phi").checked) {
//         price = "1";
//     } else if (document.getElementById("plo").checked) {
//         price = "2";
//     }

//     var qty = "0";

//     if (document.getElementById("qhi").checked) {
//         qty = "1";
//     } else if (document.getElementById("qlo").checked) {
//         qty = "2";
//     }

//     var condition = "0";

//     if (document.getElementById("br").checked) {
//         condition = "1";
//     } else if (document.getElementById("us").checked) {
//         condition = "2";
//     } else if (document.getElementById("re").checked) {
//         condition = "3";
//     }

//     var f = new FormData();
//     f.append("s", search.value);
//     f.append("t", time);
//     f.append("p", price);
//     f.append("q", qty);
//     f.append("c", condition);
//     f.append("page", y);

//     var r = new XMLHttpRequest();

//     r.onreadystatechange = function () {
//         if (r.status == 200 && r.readyState == 4) {
//             var t = r.responseText;

//             document.getElementById("sort").innerHTML = t;

//         }
//     }

//     r.open("POST", "sortProcess.php", true);
//     r.send(f);

// }

function clearSort() {
    window.location.reload();
}

function sendId(id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "updateProduct.php";
            } else {
                // alert(t);
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "sendIdProcess.php?id=" + id, true);
    r.send();

}

function confirmDelete(id) {
    // var result = confirm("Are you sure you want to delete this product?");
    // if (result) {
    //     deleteProduct(id);
    // }
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this product?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                deleteProduct(id);
            }
        });

}

function deleteProduct(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else {
                // alert(t);
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "deleteProduct.php?id=" + id, true);
    r.send();
}

function updateProduct() {
    var title = document.getElementById("title");
    var clr = document.getElementById("clr");
    var qty = document.getElementById("qty");
    var cost = document.getElementById("cost");
    var dwc = document.getElementById("dwc");
    var doc = document.getElementById("doc");
    var description = document.getElementById("desc");
    var f1 = document.getElementById("file1");
    var f2 = document.getElementById("file2");
    var f3 = document.getElementById("file3");
    var f4 = document.getElementById("file4");
    // var img1 = document.getElementById("productImage1");
    // var img2 = document.getElementById("productImage2");
    // var img3 = document.getElementById("productImage3");
    // var img4 = document.getElementById("productImage4");
    // var image = document.getElementById("imageuploader");


    var f = new FormData();
    f.append("t", title.value);
    f.append("c", clr.value);
    f.append("q", qty.value);
    f.append("cost", cost.value);
    f.append("dwc", dwc.value);
    f.append("doc", doc.value);
    f.append("d", description.value);
    // f.append("src1", img1.src);
    // f.append("src2", img2.src);
    // f.append("src3", img3.src);
    // f.append("src4", img4.src);

    if (f1.files.length > 0) {
        f.append("img0", f1.files[0]);
    };
    if (f2.files.length > 0) {
        f.append("img1", f2.files[0]);
    };
    if (f3.files.length > 0) {
        f.append("img2", f3.files[0]);
    };
    if (f4.files.length > 0) {
        f.append("img3", f4.files[0]);
    };

    // var file_count = image.files.length;
    // for (var i = 0; i < file_count; i++) {
    //     f.append("img" + i, image.files[i]);
    // }

    var r = new XMLHttpRequest();
r.onreadystatechange = function () {
    if (r.readyState == 4) {
        if (r.status == 200) {
            var t = r.responseText;
            if (t.trim() == "success") {
                window.location = "manageProducts.php";
            } else {
                alert(t);
            }
        } else {
            alert("An error occurred while updating the product.");
        }
    }
};
r.open("POST", "updateProductProcess.php", true);
r.send(f);
}

function basicSearch(x) {
    var text = document.getElementById("kw").value;
    var select = document.getElementById("c").value;

    var f = new FormData();
    f.append("t", text);
    f.append("s", select);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("basicSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "basicSearchProcess.php", true);
    r.send(f);
}

function advancedSearch(x) {

    var txt = document.getElementById("t");
    var category = document.getElementById("category");
    var subcategory = document.getElementById("subcat");
    var brand = document.getElementById("brand");
    var model = document.getElementById("m");
    var condition = document.getElementById("c2");
    var color = document.getElementById("c3");
    var from = document.getElementById("pf");
    var to = document.getElementById("pt");
    var sort = document.getElementById("s");

    var f = new FormData();

    f.append("t", txt.value);
    f.append("cat", category.value);
    f.append("subcat", subcategory.value);
    f.append("b", brand.value);
    f.append("mo", model.value);
    f.append("con", condition.value);
    f.append("col", color.value);
    f.append("pf", from.value);
    f.append("pt", to.value);
    f.append("s", sort.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            // alert(t);
            document.getElementById("view_area").innerHTML = t;
        }
    }

    r.open("POST", "advancedSearchProcess.php", true);
    r.send(f);

}

function changeImage(imagePath) {
    document.getElementById('product-image').src = imagePath;
}

function qty_inc(qty) {

    var input = document.getElementById("qty_input");

    if (input.value < qty) {

        var new_value = parseInt(input.value) + 1;
        input.value = new_value;

    } else {

        // alert("You have reched to the Maximum");
        swal("You have reched to the Maximum quantity");
        input.value = qty;

    }

}

function qty_dec() {
    var input = document.getElementById("qty_input");

    if (input.value > 1) {

        var new_value = parseInt(input.value) - 1;
        input.value = new_value;

    } else {

        // alert("You have reched to the Minimum");
        swal("You have reched to the Minimum quantity");
        input.value = 1;

    }
}

function changeButtonColor(button) {
    const buttons = document.querySelectorAll('.nav-link');
    buttons.forEach(btn => btn.classList.remove('bg-secondary-subtle', 'text-black'));

    button.classList.add('bg-secondary-subtle', 'text-black');
}

function watchSearch(x) {
    var text = document.getElementById("kw").value;

    var f = new FormData();
    f.append("t", text);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("v-pills-home").innerHTML = t;
        }
    }

    r.open("POST", "watchlistSearchProcess.php", true);
    r.send(f);
}

function confirmRemove(id) {
    // var result = confirm("Are you sure you want to remove this product from your watch list?");
    // if (result) {
    //     RemoveProduct(id);
    // }
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to remove this product?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                RemoveProduct(id);
            }
        });
}

function RemoveProduct(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else {
                // alert(t);
                swal("Oops!", t, "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "watchlistProductRemove.php?id=" + id, true);
    r.send();
}

function addWatchlist(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "Added") {
                // alert("Product added to the watchlist successfully.");
                swal("Success!", "Product added to the watchlist successfully.", "success");
            } else if (t == "Removed") {
                // alert("Product removed from watchlist successfully.");
                swal("Success!", "Product removed from the watchlist successfully.", "success");
            } else {
                // alert(t);
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "addWatchlist.php?id=" + id, true);
    r.send();
}

function cartqty_inc(qty, id) {
    var qtyInputId = "cartqty_input_" + id;
    var input = document.getElementById(qtyInputId);

    if (input.value < qty) {

        var new_value = parseInt(input.value) + 1;
        input.value = new_value;

    } else {

        // alert("You have reched to the Maximum");
        swal("You have reched to the Maximum quantity");
        input.value = qty;

    }

}

function cartqty_dec(id) {
    var qtyInputId = "cartqty_input_" + id;
    var input = document.getElementById(qtyInputId);

    if (input.value > 1) {

        var new_value = parseInt(input.value) - 1;
        input.value = new_value;

    } else {

        // alert("You have reched to the Minimum");
        swal("You have reched to the Minimum quantity");
        input.value = 1;

    }
}

function updateqty(item, id) {
    var qtyInputId = "cartqty_input_" + item;
    var qty = document.getElementById(qtyInputId);

    var f = new FormData();
    f.append("qty", qty.value);
    f.append("id", id);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
        }
    }

    r.open("POST", "qtyUpdateProcess.php", true);
    r.send(f);
}

function removeFromCart(id) {
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to remove this product?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                removeFromCartConfirm(id);
            }
        });
}

function removeFromCartConfirm(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else {
                // alert(t);
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "removeFromCartProcess.php?id=" + id, true);
    r.send();
}

function addtocart(id) {
    var qty = document.getElementById("qty_input");

    var f = new FormData();
    f.append("qty", qty.value);
    f.append("id", id);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "Added") {
                // alert("Product added to the cart successfully.");
                swal("Success!", "Product added to the cart successfully.", "success", {
                    button: "OK",
                });
            } else {
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("POST", "addToCartProcess.php", true);
    r.send(f);
}

function homeaddtocart(id) {

    var f = new FormData();
    f.append("id", id);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "Added") {
                swal("Success!", "Product added to the cart successfully.", "success");
            } else {
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("POST", "addToCartProcess.php", true);
    r.send(f);
}

function total(item, price) {
    var qtyInputId = "cartqty_input_" + item;
    var qty = document.getElementById(qtyInputId).value;
    var totalPriceId = "totalPrice_" + item;
    var totalPricetag = document.getElementById(totalPriceId);
    var f = new FormData();
    f.append("qty", qty);
    f.append("price", price);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            totalPricetag.innerHTML = t;
            window.location.reload();
        }
    }

    r.open("POST", "itemTotalProcess.php", true);
    r.send(f);
}

function seeAll(page, cat) {

    var f = new FormData();
    f.append("page", page);
    f.append("cat", cat);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("basicSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "seeAllProcess.php", true);
    r.send(f);
}

function toggleDropdown() {
    var dropdown = document.getElementById("myDropdown");
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
}

function popUp() {
    // document.getElementById("popup-body").innerHTML = "Welcome to our website! Please register to access full features";
    // var myModal = new mdb.Modal(document.getElementById('popup'));
    // myModal.show();
    swal("Welcome to our website!", "Please register to access full features");
}

function changeUserStatus(i) {

    var mailElement = document.getElementById("mail" + i);
    var email = mailElement.innerHTML;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "active" || t == "inactive") {
                window.location.reload();
            } else {
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "changeUserStatusProcess.php?e=" + email, true);
    r.send();
}

function addTest2Product() {
    var subcat = document.getElementById("subcat");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");
    var condition = 0;
    if (document.getElementById("b").checked) {
        condition = 1;
    } else if (document.getElementById("u").checked) {
        condition = 2;
    } else if (document.getElementById("r").checked) {
        condition = 3;
    }
    var clr = document.getElementById("clr");
    var qty = document.getElementById("qty");
    var cost = document.getElementById("cost");
    var dwc = document.getElementById("dwc");
    var doc = document.getElementById("doc");
    var desc = document.getElementById("desc");

    // alert("subcat="+subcat.value);
    // alert("brand="+brand.value);
    // alert("model="+model.value);
    // alert("title="+title.value);
    // alert("condition="+condition);
    // alert("color="+clr.value);
    // alert("qty="+qty.value);
    // alert("cost="+cost.value);
    // alert("delivery in colombo ="+dwc.value);
    // alert("delivery other="+doc.value);
    // alert("description="+desc.value);

    var f = new FormData();
    f.append("subcat", subcat.value);
    f.append("b", brand.value);
    f.append("m", model.value);
    f.append("t", title.value);
    f.append("con", condition);
    f.append("col", clr.value);
    f.append("qty", qty.value);
    f.append("cost", cost.value);
    f.append("dwc", dwc.value);
    f.append("doc", doc.value);
    f.append("desc", desc.value);

    var fileInputs = ["file1", "file2", "file3", "file4"];
    fileInputs.forEach(function (fileInputId, index) {
        var fileInput = document.getElementById(fileInputId);
        if (fileInput.files.length > 0) {
            f.append("img" + index, fileInput.files[0]);
        }
    });

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                window.location.reload();
            } else {
                // document.getElementById("adpmsg").innerHTML = t;
                // document.getElementById("adpmsgdiv").className = "d-block";
                swal("Oops!", t, "error", {
                    button: "OK",
                });
            }

        }
    }

    r.open("POST", "addProductProcess.php", true);
    r.send(f);

}

function fileSelect(event, imgNumber) {
    var input = event.target;
    var file = input.files[0];

    if (file) {
        var url = window.URL.createObjectURL(file);
        var img = document.getElementById('productImage' + imgNumber);
        img.src = url;
        img.className = "img-fluid d-block";
    }
}

function addSubC() {
    var cat = document.getElementById("subCM").value;
    var subC = document.getElementById("newSubC").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                window.location.reload();
            } else if (t == "already") {
                // document.getElementById("sCMmsg").innerHTML = "This sub category already exists";
                // document.getElementById("sCMmsgdiv").className = "d-block";
                swal("ohh!", "This sub category already exists!", "warning");

            } else {
                // document.getElementById("sCMmsg").innerHTML = t;
                // document.getElementById("sCMmsgdiv").className = "d-block";
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "addNewSubcategory.php?c=" + encodeURIComponent(cat) + "&s=" + encodeURIComponent(subC), true);
    r.send();
}

function addBrand() {
    var cat = document.getElementById("brandM").value;
    var brand = document.getElementById("newBrand").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                window.location.reload();
            } else {
                // document.getElementById("bMmsg").innerHTML = t;
                // document.getElementById("bMmsgdiv").className = "d-block";
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "addNewBrand.php?c=" + encodeURIComponent(cat) + "&b=" + encodeURIComponent(brand), true);
    r.send();
}

function addModel() {
    var cat = document.getElementById("modelM").value;
    var brand = document.getElementById("modelbM").value;
    var model = document.getElementById("newModel").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                window.location.reload();
            } else if (t == "already") {
                // document.getElementById("mMmsg").innerHTML = "This Model already exists";
                // document.getElementById("mMmsgdiv").className = "d-block";
                swal("ohh!", "This model already exists!", "warning");
            } else {
                // document.getElementById("mMmsg").innerHTML = t;
                // document.getElementById("mMmsgdiv").className = "d-block";
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "addNewModel.php?c=" + encodeURIComponent(cat) + "&b=" + encodeURIComponent(brand) + "&m=" + encodeURIComponent(model), true);
    r.send();
}

function printDiv() {
    var originalContent = document.body.innerHTML;
    var printArea = document.getElementById("printArea").innerHTML;

    document.body.innerHTML = printArea;

    window.print();

    document.body.innerHTML = originalContent;

}

function checkout() {
    // alert("OK");

    var f = new FormData();
    f.append("cart", true);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            alert(t);
            // var payment = JSON.parse(t);
            // doCheckout(payment, "checkoutProcess.php");

        }
    }

    r.open("post", "paymentProcess.php", true);
    r.send(f);

}

function doCheckout(payment, path) {
    // Payment completed. It can be a successful failure.
    payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        // Note: validate the payment and show success or failure page to the customer

        var f = new FormData();
        f.append("payment", JSON.stringify(payment));

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.status == 200 && r.readyState == 4) {
                var t = r.responseText;
                // alert(t);
                var order = JSON.parse(t);
                if (order.resp == "success") {
                    // window.location.reload();
                    window.location = "invoice.php?orderId=" + order.order_id;
                } else {
                    // alert(t);
                    swal("Oops!", "Something went wrong!", "error", {
                        button: "OK",
                    });
                }
            }
        }


        r.open("POST", path, true);
        r.send(f);

    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        console.log("Payment dismissed");
    };

    // Error occurred
    payhere.onError = function onError(error) {
        // Note: show an error page
        console.log("Error:" + error);
    };

    // Show the payhere.js popup, when "PayHere Pay" is clicked
    // document.getElementById('payhere-payment').onclick = function (e) {
    payhere.startPayment(payment);
    // };
}

function paynow(pid) {

    var qty = document.getElementById("qty_input").value;

    var f = new FormData();
    f.append("cart", false);
    f.append("pid", pid);
    f.append("qty", qty);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            // alert(t);
            if (t == "address error") {
                swal("oh!", "Please Update your Address in Profile", "warning");
            } else {
                var payment = JSON.parse(t);
                payment.product_id = pid;
                payment.qty = qty;
                doCheckout(payment, "payNowProcess.php");
            }
        }
    }


    r.open("POST", "paymentProcess.php", true);
    r.send(f);

}

function loadChart() {
    var ctx = document.getElementById('myChart');

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            // alert(t);
            var data = JSON.parse(t);

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: '# of Votes',
                        data: data.data,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        }
    }


    r.open("POST", "loadChartProcess.php", true);
    r.send();
}

function reload() {
    document.getElementById("form").reset();
}

function changeOrderStatus(id, i) {

    var status = document.getElementById("os" + i).value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                swal({
                    title: "Success!",
                    text: "Order Status Updated successfully!",
                    icon: "success",
                    button: "OK!",
                })
                  .then((ok) => {
                    if (ok) {
                        window.location.reload();
                    }
                });
            } else {
                swal("Oops!", "Something went wrong!", "error", {
                    button: "OK",
                });
            }
        }
    }

    r.open("GET", "changeOrderStatusProcess.php?s=" + encodeURIComponent(status) + "&id=" + encodeURIComponent(id), true);
    r.send();
}
