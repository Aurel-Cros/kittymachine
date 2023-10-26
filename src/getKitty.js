import { useState, useEffect } from "react";
import useFetch from "use-http";

const GetKitty = () => {
	const [flag, setFlag] = useState(false);

	const { loading, error, data = [] } = useFetch(
		"https://api.thecatapi.com/v1/images/search",
		{ cachePolicy: "no-cache" },
		[flag]
	);

	const trigger = () => {
		if (!loading) setFlag(a => !a);
	};

	useEffect(() => {
		const refresh = km_options['kittymachine_field_auto_refresh'] === "true" ? true : false;
		if (!refresh)
			return;
		const frequency = Number(km_options['kittymachine_field_auto_refresh_frequency']);
		const interval = setInterval(() => {
			trigger();
		}, frequency * 1000);

		return () => { clearInterval(interval) }
	}, [trigger]);

	const { url, id, width, height } = data.find(() => true) || {};

	return (
		<div style={{ display: "flex", gap: "1rem", flexFlow: "column", alignItems: "center" }}>
			<button id="refresh" onClick={trigger}>
				Un autre !
			</button>
			{loading ? (
				"Chat-rgement..."
			) : error ? (
				"Chat-tastrophe, une erreur : " + error
			) : (
				<img src={url} alt={`Cat number ${id}`} width={width} height={height} />
			)}
		</div>
	);
};

export default GetKitty;
