import React, { Component } from 'react';
import FilterBar from './Filter_bar';
import FilterModal from './Filter_modal';
import PropertyCard from './Property_card';
import NoProperty from './No_property';
import { base_path } from './utils.js';

class App extends Component {

  state = {
    properties: [],
    sort: 'none',
    filter: {
      gender: 'none'
    }
  }

  componentDidMount() {
    const search = window.location.search;
    const params = new URLSearchParams(search);
    const city_name = params.get('city');

    fetch(`${base_path}/php/get_properties.php?city=${city_name}`)
      .then(response => response.json())
      .then(propertiesData => {
        this.setState({
          properties: propertiesData
        })
      }).catch(error => {
        console.log('Error fetching and parsing data', error);
      });
  }

  toggleInterested(property_id) {
    console.log(property_id);
    fetch(`${base_path}/php/toggle_intrested.php?property_id=${property_id}`)
      .then(response => response.json())
      .then(responseData => {
        if (responseData.success) {
          this.updateInterested(property_id)
          console.log('success toggle!')
        } else if (!responseData.success && !responseData.logged_in) {
          console.log('Not logged in!');
          window.$("#login-modal").modal("show");
        }
      })
  }

  updateInterested(property_id) {
    let properties = [...this.state.properties];
    properties.forEach(property => {
      if (property.p_id === property_id) {
        property.is_interested = !property.is_interested;
        if (property.is_interested) {
          property.like_count++;
        } else {
          property.like_count--;
        }
      }
    })

    this.setState({
      properties: properties
    })
  }

  updateSort = sort => {
    this.setState({
      sort: sort
    })
  }

  updateFilter = filter => {
    this.setState({
      filter: {
        gender: filter
      }
    })
  }


  render() {

    let new_properties = [...this.state.properties];

    // Sorting
    if (this.state.sort !== "none") {
      if (this.state.sort === "desc") {
        new_properties.sort((a, b) => b.price - a.price);
      } else {
        new_properties.sort((a, b) => a.price - b.price);
      }
    }

    // Filter
    if (this.state.filter.gender !== "none") {
      new_properties = new_properties.filter(property =>
        property.gender === this.state.filter.gender
      );
    }

    console.log('start property cards\n'+ new_properties+'\nstart prop card');

    //collect resulted properties
    var property_cards;
    if (new_properties.length > 0) {
      property_cards = new_properties.map(property => 
        <PropertyCard
          property={property}
          toggleInterested={() => this.toggleInterested(property.p_id)}
          key={property.p_id} />
      );
    } else {
      property_cards = <NoProperty />;
    }


    return (
      <>
        <center>
          <FilterBar
            currentSort={this.state.sort}
            currentFilter={this.state.filter}
            updateSort={this.updateSort} />

          <div className="properties container-fluid">
            {property_cards}
          </div>
          </center>

        <FilterModal
        currentFilter = {this.state.filter}
        updateFilter = {this.updateFilter} />
      </>
    )
  }
};

export default App;
