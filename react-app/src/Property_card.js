import React from 'react';
import Stars from './Stars';
import Interested from './Interested';
import { base_path } from './utils.js';

const PropertyCard = props => {
    let total_rating = (parseFloat(props.property.rating_clean) + parseFloat(props.property.rating_food) + parseFloat(props.property.rating_safety)) / 3;
    total_rating = Math.round(total_rating * 10) / 10;
    total_rating = total_rating.toFixed(1);

    let gender_logo;
    if (props.property.gender === "male") {
        gender_logo = <i className="fa-solid fa-person"></i>;
    } else if (props.property.gender === "female") {
        gender_logo = <i className="fa-solid fa-person-dress border border-start"></i>;
    } else {
        gender_logo = <div><i className="fa-solid fa-person"></i>
            <i className="fa-solid fa-person-dress border border-start"></i></div>;
    }

    return (
        <div className="property-card row my-3 d-flex align-items-center justify-content-center">
            <div className="room-pic col-lg-4 col-12 rounded ">
                <img src={`${base_path}/${props.property.p_image}`} alt="room" />
            </div>
            <div className="room-info col-lg-8 col-12 py-3 d-flex flex-column align-items-start">
                <div className="icons d-flex justify-content-between w-100">

                    <Stars rating={total_rating} />

                    <Interested
                        is_interested={props.property.is_interested}
                        toggleInterested={props.toggleInterested}
                        user_count={props.property.like_count}
                        p_id={props.property.p_id} />
                </div>

                <h3>{props.property.p_name}</h3>
                <p className="text-start">{props.property.address}</p>
                <div className="d-flex">
                    {gender_logo}
                </div>

                <div className="price mt-2 d-flex align-items-center justify-content-between w-100">
                    <p><span>₹ {parseFloat(props.property.price).toFixed(0)}/-</span> per month</p>
                    <a href={`property_detail.php?property_id=${props.property.p_id}&c_id=${props.property.city_id}`}><button type="button" className="btn btn-success px-3 px-lg-5">View</button></a>
                </div>
            </div>
        </div>
    )
};

export default PropertyCard;