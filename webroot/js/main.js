const utils = {
	formatDate: function (date) {
		var hours = date.getHours();
		var minutes = date.getMinutes();
		minutes = minutes < 10 ? '0' + minutes : minutes;
		var strTime = hours + ':' + minutes;
		return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "  " + strTime;
	},

	postTestResult: function (result, callback) {
		const xhr = new XMLHttpRequest();
		xhr.open('POST', 'http://localhost/results/submit', true);
		xhr.onload = callback;
		xhr.send(result);
	}
}