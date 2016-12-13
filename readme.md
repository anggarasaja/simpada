demo datatables ada di **localhost/demo-datatables**

demo opentbs ada di **localhost/demo-opentbs**

!!NOTE!!

fitur *onShow* di opentbs tidak berfungsi karena ada isu dengan variabel $GLOBALS. Variabel yang dideklarasikan di dalam controller tidak masuk ke dalam array $GLOBALS, sedangkan fitur *onShow* pada opentbs mengambil variabel dalam array $GLOBALS. 

tambahkan *$TBS->SetOption("noerr",true);* untuk menghilangkan pesan kesalahan/error
