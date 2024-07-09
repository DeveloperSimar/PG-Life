import React from "react";

const Interested = (props) => {
  var heart_image_class;
    if (props.is_interested) {
        heart_image_class = "fa-solid";
    } else {
        heart_image_class = "far";
    }

    return (
        <div className="interested-container">
      <i
        className={`is-interested-image ${heart_image_class} fa-heart property-${props.p_id}`} data-property={`${props.p_id}`}
        onClick={() => props.toggleInterested(props.p_id)}
      ></i>
      <div className="interested-text">
        <span className={`interested-user-count like_count_${props.p_id}`}>{props.user_count}</span> interested
      </div>
    </div>
    );
};

export default Interested;