const company_cai = document.getElementById('company_cai');
const company_phone = document.getElementById('company_phone');
const maskCAIOptions = {
    mask: '000000-000000-000000-000000-000000-00'
};
const maskPhoneOptions = {
    mask: '0000-0000'
};
const company_cai_mask = IMask(company_cai, maskCAIOptions);
const company_phone_mask = IMask(company_phone, maskPhoneOptions);