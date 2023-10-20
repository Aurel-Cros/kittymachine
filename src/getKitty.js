const getKitty = () => {
	fetch("https://api.thecatapi.com/v1/images/search")
		.then(r => r.json())
		.then(data => {
			const img = document.createElement("img");
			img.src = data[0].url;
			img.alt = `Cat number ${data[0].id}`;
			img.width = data[0].width;
			img.height = data[0].height;
			document.querySelector("#kitty").replaceChildren(img);
		});
};

export default getKitty;
