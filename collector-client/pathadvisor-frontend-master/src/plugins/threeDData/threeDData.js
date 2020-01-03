import React from 'react'
import threeDDataMark from './threeDDataMark.png';

const markWidth = 12;
const markHeight = 24;

var markID = "threeDData";

function threeDDataStoration({ setMapItems, removeMapItem, from }) {
  console.log('threeDDataStoration rendered');
  // put a threeDDataMark in map if user specified the 'from' value in input field
  const { data: { coordinates: [x, y] = [null, null], floor = null } = {} } = from;

  if (x && y && floor) {
    
  }

  return null
}



function showInfoAndUpload({from}){
    if(!(from.data.floor && from.data.coordinates[0] && from.data.coordinates[1])){return null;}
    else{
        return(
            <h3>
                Current position is floor {from.data.floor} at ({from.data.coordinates[0]},{from.data.coordinates[1]}), the id is [ markID{from.data.coordinates[0]},{from.data.coordinates[1]},{from.data.floor} ]
            </h3>
        );
    }
}

const MapCanvasPlugin = {
  Component: threeDDataStoration,
  connect: ['from', 'setMapItems', 'removeMapItem'],
};
//const OverlayHeaderPlugin = { Component: OverlayHeaderPlugin, connect: [] };
const PrimaryPanelPlugin  = { Component: showInfoAndUpload, connect: ['from'] };

const id = 'threeDData';
export { id, MapCanvasPlugin, PrimaryPanelPlugin };
