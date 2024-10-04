function delete_indicator(id) {
    swal({
        title: "Konfirmasi ?",
        text: "Yakin mau menghapus record ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((isTrue) => {
            if (isTrue) {

                        swal('Info', 'Nanti ya', 'success');
            }
        });
}