import { useState, useEffect } from "react";
import useFetchCat from "./customHooks/useFetchCat";

const GetKitty = () => {
	const [flag, setFlag] = useState(false);

	const { loading, error, data = [] } = useFetchCat(
		"https://api.thecatapi.com/v1/images/search",
		{},
		[flag]
	);

	const trigger = () => {
		if (!loading) setFlag(a => !a);
	};

	useEffect(() => {
		const refresh = km_options['kittymachine_field_auto_refresh'] === "true" ? true : false;
		const frequency = Number(km_options['kittymachine_field_auto_refresh_frequency']);

		if (!refresh)
			return;

		const interval = setInterval(() => {
			trigger();
		}, frequency * 1000);

		return () => { clearInterval(interval) }

	}, [trigger]);

	const { url, id, width, height } = data.find(() => true) || {};

	const loader = <div className="loader-container"><p>Meow-ding...</p><div className="loader"></div></div>;
	const imgEl =
		<img src={url} alt={`Cat number ${id}`} width={width} height={height} />;

	return (
		<div style={{ display: "flex", gap: "1rem", flexFlow: "column", alignItems: "center" }}>
			<button id="refresh" onClick={trigger} {...{ disabled: loading ? true : false }}>
				Another !
			</button>
			{error ? <>
				<p>Cat-astrophe, an error occured :</p>
				<p>{error}</p>
			</>
				: loading ? (
					loader
				) : (
					imgEl
				)}
		</div>
	);
};

export default GetKitty;
