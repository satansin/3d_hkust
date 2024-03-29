import React, { Component } from 'react';
import style from './ContextMenu.module.css';
import fetchMapItemByCoorRequest from '../../sagas/requests/fetchMapItemByCoorRequest';

class ContextMenu extends Component {
  state = {
    menuTitle: null,
    isContextMenuDisplay: false,
    clientX: null,
    clientY: null,
    clientMapX: null,
    clientMapY: null,
    nodeId: null,
  };

  ref = React.createRef();

  componentDidMount() {
    this.props.addCanvasContextMenuListener(
      async ({ originalEvent, clientX, clientY, clientMapX, clientMapY }) => {
        const {
          floorStore: { floors, buildings },
          floor,
        } = this.props;

        originalEvent.preventDefault();
        const menuTitle = `${
          floors && floors[floor] && floors[floor].name
            ? `Floor ${floors[floor].name} - ${buildings[floors[floor].buildingId].name}`
            : buildings[floors[floor].buildingId].name
        } (${clientMapX}, ${clientMapY})`;

        this.setState({
          nodeId: null,
          menuTitle,
          isContextMenuDisplay: true,
          clientX,
          clientY,
          clientMapX,
          clientMapY,
        });

        const {
          data: { name, nodeId },
        } = await fetchMapItemByCoorRequest(floor, clientMapX, clientMapY);

        this.setState(name ? { menuTitle: name, nodeId } : { nodeId });
      },
    );

    document.addEventListener('mousedown', e => {
      let node = e.target;

      while (node !== null) {
        if (node === this.ref.current) {
          return;
        }
        node = node.parentElement;
      }

      this.hideContextMenu();
    });
  }

  hideContextMenu = () => {
    this.setState({ isContextMenuDisplay: false });
  };

//neeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeew function here
  storeThreeDData = () => {
    const { clientMapX, clientMapY } = this.state;
    const { APIEndpoint, floor } = this.props;
    window.open(
      `http://localhost:80/3DData/DataUpload.php?floor=${floor}&x=${clientMapX}&y=${clientMapY}`,
      '_blank',
      // 'height=600,width=700',
    );
    this.hideContextMenu();
  };
  showThreeDData = () => {
    const { clientMapX, clientMapY } = this.state;
    const { APIEndpoint, floor } = this.props;
    // window.open(
    //   `http://localhost:80/3DData/DataUpload.php?floor=${floor}&x=${clientMapX}&y=${clientMapY}`,
    //   '_blank',
    //   'height=600,width=700',
    // );
    window.open(
      `http://rwcpu1.cse.ust.hk/3d-map/visualization/plyViewer/plane.html`,
      '_blank'
    );
    this.hideContextMenu();
  };

  suggestLocation = () => {
    const { clientMapX, clientMapY } = this.state;
    const { APIEndpoint, floor } = this.props;
    window.open(
      `${APIEndpoint()}/suggest.php?type=location&floor=${floor}&x=${clientMapX}&y=${clientMapY}`,
      '_blank',
      'height=300,width=350',
    );
    this.hideContextMenu();
  };

  setLocation = direction => () => {
    const { linkTo, floor } = this.props;
    const { clientMapX, clientMapY, menuTitle, nodeId } = this.state;

    linkTo({
      search: true,
      [direction]: {
        name: menuTitle,
        data: {
          id: nodeId,
          type: 'nodeId',
          floor,
          value: menuTitle,
          coordinates: [clientMapX, clientMapY],
        },
      },
    });

    this.hideContextMenu();
  };

  render() {
    const { menuTitle, isContextMenuDisplay, clientX, clientY, nodeId } = this.state;
    return isContextMenuDisplay ? (
      <ul
        ref={this.ref}
        className={style.body}
        style={{ left: clientX, top: clientY }}
        onContextMenu={e => {
          e.preventDefault();
        }}
      >
        <li className={style.heading}>{menuTitle}</li>
        {nodeId ? (
          <>
            <li>
              <button type="button" className={style.button} onClick={this.setLocation('from')}>
                Starts from here
              </button>
            </li>
            <li>
              <button type="button" className={style.button} onClick={this.setLocation('to')}>
                Stops to here
              </button>
            </li>
            

          </>
        ) : (
          <li className={style.heading}> Loading location... </li>
        )}
        <li>
          <button type="button" className={style.button} onClick={this.suggestLocation}>
            Suggests a location here
          </button>
        </li>
        <li>
          <button type="button" className={style.button} onClick={this.storeThreeDData}>
            Store 3D data at this position
          </button>
        </li>
        <li>
          <button type="button" className={style.button} onClick={this.showThreeDData}>
            Show 3D data at this position
          </button>
        </li>
      </ul>
    ) : null;
  }
}

const MapCanvasPlugin = {
  Component: ContextMenu,
  connect: ['addCanvasContextMenuListener', 'floorStore', 'floor', 'APIEndpoint', 'linkTo'],
};

const id = 'CONTEXT_MENU';
export { id, MapCanvasPlugin };
