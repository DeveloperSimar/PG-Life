import React from 'react';
//import { base_path } from './utils.js';

const FilterBar = (props)=>{
    return(
        <div className="filters d-flex align-items-center justify-content-evenly">
                <div className={"filter" + (props.currentFilter.gender === "none" ? " sort-active" : "")} data-bs-toggle="modal" data-bs-target="#filter-modal">
                    <img src={`/img/filter.png`} alt='filter' />
                    <p>Filter</p>
                </div>
                <div className={"filter" + (props.currentSort === "desc" ? " sort-active" : "")} onClick={()=>{props.updateSort('desc')}}>
                    <img src={`/img/desc.png`} alt="high rent" />
                    <p>Highest rent first</p>
                </div>
                <div className={"filter" + (props.currentSort === "asc" ? " sort-active" : "")} onClick={()=>{props.updateSort('asc')}}>
                    <img src={`/img/asc.png`} alt="low rent" />
                    <p>Loweset rent first</p>
                </div>
        </div>
    )
};

export default FilterBar;