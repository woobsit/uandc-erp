declare module '@mapbox/mapbox-gl-geocoder' {
  import { LngLatLike } from 'mapbox-gl';

  interface MapboxGeocoderOptions {
    accessToken: string;
    types?: string;
    placeholder?: string;
    bbox?: [number, number, number, number];
    proximity?: LngLatLike;
    countries?: string;
    language?: string;
    filter?: (feature: any) => boolean;
    localGeocoder?: (query: string) => any[];
    reverseGeocode?: boolean;
    enableEventLogging?: boolean;
    marker?: boolean | object;
    flyTo?: boolean | object;
  }

  export default class MapboxGeocoder {
    constructor(options: MapboxGeocoderOptions);
    on(type: string, callback: (event: any) => void): void;
    addTo(container: string | HTMLElement): void;
    getProximity(): LngLatLike;
    setProximity(proximity: LngLatLike): void;
    getRenderFunction(): (item: any) => string;
    setRenderFunction(renderFunction: (item: any) => string): void;
    getLanguage(): string;
    setLanguage(language: string): void;
    getZoom(): number;
    setZoom(zoom: number): void;
    getFlyTo(): boolean | object;
    setFlyTo(flyTo: boolean | object): void;
    getPlaceholder(): string;
    setPlaceholder(placeholder: string): void;
    getBbox(): [number, number, number, number];
    setBbox(bbox: [number, number, number, number]): void;
    getCountries(): string;
    setCountries(countries: string): void;
    getTypes(): string;
    setTypes(types: string): void;
    getFilter(): (feature: any) => boolean;
    setFilter(filter: (feature: any) => boolean): void;
    clear(): void;
    query(query: string): void;
  }
}
