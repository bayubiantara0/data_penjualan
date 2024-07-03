const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: false,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

function deletepenjualan($id) {
    var post_id = $id;
    var token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Kamu Yakin?",
        text: "ingin menghapus data ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "TIDAK",
        confirmButtonText: "YA, HAPUS!",
    }).then((result) => {
        if (result.isConfirmed) {
            //fetch to delete data
            $.ajax({
                url: `/datapenjualan/delete/${post_id}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    //show success message
                    location.reload(true);
                    Toast.fire({
                        icon: "success",
                        title: `${response.message}`,
                    });
                    //remove post on table
                    $(`#index_${post_id}`).remove();
                },
            });
        }
    });
}

function viewdata($id) {
    var post_id = $id;
    $.ajax({
        url: `/datapenjualan/show/${post_id}`,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('[name="nmbarang"]').text(data.nama);
            $('[name="ssstok"]').text(data.sisa_stok);
            $('[name="jmterjual"]').text(data.jumlah_terjual);
            $('[name="tgtransaksi"]').text(data.tanggal_transaksi);

            $("#modalview").modal("show");
        },
    });
}
