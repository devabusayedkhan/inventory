function textValidation(obj) {
    const textarea = document.createElement('textarea');

    const decode = (str) => {
        textarea.innerHTML = str;
        return textarea.value;
    };

    const newObj = {};

    for (const key in obj) {
        if (!obj.hasOwnProperty(key)) continue;

        const value = obj[key];

        if (typeof value === 'string') {
            newObj[key] = decode(value); // শুধু string গুলো decode করো
        } else {
            newObj[key] = value; // অন্যগুলোর মান অপরিবর্তিত
        }
    }

    return newObj;
}

function DMY(isoDate) {
    const date = new Date(isoDate);
    const day = date.getDate().toString().padStart(2, '0');
    const month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                   "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][date.getMonth()];
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}