const range_start = document.getElementById('folio_authorized_range_start');
const range_end = document.getElementById('folio_authorized_range_end');
const maskOptions = {
    mask: '000-000-00-00000000'
};
const range_start_mask = IMask(range_start, maskOptions);
const range_end_mask = IMask(range_end, maskOptions);