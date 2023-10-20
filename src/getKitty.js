import { useState, useEffect } from "react";

const GetKitty = () => {
	const [img, setImg] = useState({
		src: "",
		alt: "No kitty yet :(",
		width: 100,
		height: 100,
	});

	const fetchKitty = async () => {
		setImg(
			await fetch("https://api.thecatapi.com/v1/images/search")
				.then(r => r.json())
				.then(data => {
					const img = {};
					img.src = data[0].url;
					img.alt = `Cat number ${data[0].id}`;
					img.width = data[0].width;
					img.height = data[0].height;
					return img;
				})
		);
	};

	useEffect(() => {
		fetchKitty();
	}, []);

	return (
		<div style={{ display: "flex", gap: "1rem", flexFlow: "column", alignItems: "center" }}>
			<button id="refresh" onClick={fetchKitty}>
				Un autre !
			</button>
			<img src={img.src} alt={img.alt} width={img.width} height={img.height} />
		</div>
	);
};

export default GetKitty;
