import React from 'react';

const Stars = (props) =>{

    var stars = [];
    let star;
  for (let i = 0; i < 5; i++) {
    if (props.rating >= i + 0.8) {
      star = <i className="fas fa-star" key={i}></i>;
    } else if (props.rating >= i + 0.3) {
      star = <i className="fas fa-star-half-alt" key={i}></i>;
    } else {
      star = <i className="far fa-star" key={i}></i>;
    }

    stars.push(star);
  }

    return(
    <div className="stars d-flex align-items-center" title={props.rating}>
        {stars}
    </div>
    );
};

export default Stars;