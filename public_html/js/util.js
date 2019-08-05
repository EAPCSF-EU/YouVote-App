var timezone_offset_minutes = new Date().getTimezoneOffset();
timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;

function convertToYMDHMS(d) {
    return $.format.date(d, "yyyy-MM-dd HH:mm");
}

function changeToCurrentTimeZone(dt) {
	var newDt = dt.split('-');
    dt = new Date(newDt[0] + "/" + newDt[1] + "/" + newDt[2]);
    dt.setMinutes(dt.getMinutes() + timezone_offset_minutes);
    return (dt);
}

function convertToWMDYHMA(dt) {
    return $.format.date(dt, "ddd, MMMM d yyyy hh:mm a");
}

function convertToMDYHMA(dt) {
    return $.format.date(dt, "MMM d yyyy, hh:mm a");
}